<?php
require_once './commons/env.php';
require_once './commons/function.php';
require_once './models/BaseModel.php';
require_once './models/FbPageModel.php';
require_once './models/PostModel.php';
require_once './models/PostQueueModel.php';
require_once './services/FacebookApiService.php';

// ===== Init =====
$fbService = new FacebookApiService();
$pageModel = new FbPageModel();
$postModel = new PostModel();
$queueModel = new PostQueueModel();

$results = [
    'page_token_refresh' => [],
    'queue' => [
        'processed' => 0,
        'posted' => 0,
        'failed' => 0,
        'items' => [],
    ],
];

// ===== Cron 1: Cập nhật token page =====
$pages = $pageModel->getAll();

foreach ($pages as $p) {
    $pageId = $p['page_id'];
    $userToken = $p['access_token'];

    if (!$pageId || !$userToken) {
        $results['page_token_refresh'][] = [
            'page_id' => $pageId,
            'status' => 'skip',
            'message' => 'missing token',
        ];
        continue;
    }

    $data = $fbService->getPageInfo($pageId, $userToken);

    if (!empty($data['error'])) {
        $results['page_token_refresh'][] = [
            'page_id' => $pageId,
            'status' => 'error',
            'message' => $data['error']['message'] ?? 'unknown',
        ];
        continue;
    }

    $name = $data['name'] ?? '';
    $pageToken = $data['access_token'] ?? '';
    $avatar = $data['picture']['data']['url'] ?? ("https://graph.facebook.com/{$pageId}/picture?type=square");

    $ok = $pageModel->updatePageInfo($pageId, $name, $avatar, $pageToken);
    $results['page_token_refresh'][] = [
        'page_id' => $pageId,
        'status' => $ok ? 'updated' : 'failed',
    ];
}

// ===== Cron 2: Queue worker (đăng bài hàng loạt) =====
$jobs = $queueModel->getDueQueued(8);

foreach ($jobs as $job) {
    $jobId = (int)$job['id'];
    $results['queue']['processed']++;

    // Tránh xử lý trùng nếu có nhiều cron chạy cùng lúc
    if (!$queueModel->markProcessing($jobId)) {
        $results['queue']['items'][] = [
            'id' => $jobId,
            'status' => 'skip',
            'message' => 'already claimed',
        ];
        continue;
    }

    $pageId = $job['page_id'] ?? '';
    $page = $pageModel->getByPageId($pageId);

    if (!$page || empty($page['token_page'])) {
        $queueModel->markFailed($jobId, 'Missing page token');
        $results['queue']['failed']++;
        $results['queue']['items'][] = [
            'id' => $jobId,
            'status' => 'failed',
            'message' => 'Missing page token',
        ];
        continue;
    }

    $pageToken = $page['token_page'];
    $content = (string)($job['content'] ?? '');
    $mediaType = $job['media_type'] ?? 'none';
    $mediaPath = $job['media_path'] ?? null;

    $res = null;
    $error = null;

    if ($mediaType === 'none' || empty($mediaPath)) {
        $res = $fbService->postText($pageId, $pageToken, $content, null);
    } elseif ($mediaType === 'image') {
        $paths = null;
        if (is_string($mediaPath) && strlen($mediaPath) > 0 && $mediaPath[0] === '[') {
            $paths = json_decode($mediaPath, true);
        }
        $list = is_array($paths) ? $paths : [$mediaPath];
        $photoIds = [];

        foreach ($list as $mp) {
            $abs = PATH_ROOT . $mp;
            if (!file_exists($abs)) {
                $error = "Image file not found: {$mp}";
                break;
            }
            $up = $fbService->uploadPhotoUnpublished($pageId, $pageToken, $abs);
            if (!empty($up['error'])) {
                $error = $up['error']['message'] ?? 'Upload photo failed';
                break;
            }
            if (!empty($up['id'])) {
                $photoIds[] = $up['id'];
            }
        }

        if (!$error) {
            if (empty($photoIds)) {
                $error = 'No uploaded photo id';
            } else {
                $res = $fbService->postImages($pageId, $pageToken, $content, $photoIds, null);
            }
        }
    } elseif ($mediaType === 'video') {
        $abs = PATH_ROOT . $mediaPath;
        if (!file_exists($abs)) {
            $error = "Video file not found: {$mediaPath}";
        } else {
            $res = $fbService->postVideo($pageId, $pageToken, $abs, $content, null);
        }
    } else {
        $error = "Unsupported media_type: {$mediaType}";
    }

    if (!$error && !empty($res['error'])) {
        $error = $res['error']['message'] ?? 'Unknown Facebook API error';
    }

    if ($error) {
        $queueModel->markFailed($jobId, $error);
        $results['queue']['failed']++;
        $results['queue']['items'][] = [
            'id' => $jobId,
            'status' => 'failed',
            'message' => $error,
        ];
        continue;
    }

    $fbPostId = $res['id'] ?? null;
    $queueModel->markPosted($jobId, $fbPostId);

    // Đồng bộ sang bảng posts để UI hiện lịch sử bài đã đăng
    $postModel->create([
        ':menu_id' => !empty($job['menu_id']) ? (int)$job['menu_id'] : null,
        ':page_id' => $pageId,
        ':fb_post_id' => $fbPostId,
        ':content' => $content,
        ':media_type' => $mediaType ?: 'none',
        ':media_path' => $mediaPath,
        ':status' => 'posted',
        ':scheduled_at' => null,
        ':posted_at' => date('Y-m-d H:i:s'),
    ]);

    $results['queue']['posted']++;
    $results['queue']['items'][] = [
        'id' => $jobId,
        'status' => 'posted',
        'fb_post_id' => $fbPostId,
    ];
}

// ===== Cron 3: Giữ logic cũ scheduled -> posted =====
$postModel->markScheduledToPosted();

// ===== Output =====
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => true, 'results' => $results], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);