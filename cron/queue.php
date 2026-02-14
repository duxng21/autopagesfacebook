<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
initDatabaseSchemaIfNeeded();

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/FbPageModel.php';
require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/PostQueueModel.php';
require_once __DIR__ . '/../services/FacebookApiService.php';

$fbService = new FacebookApiService();
$pageModel = new FbPageModel();
$postModel = new PostModel();
$queueModel = new PostQueueModel();

$results = [
    'processed' => 0,
    'posted' => 0,
    'failed' => 0,
    'items' => [],
];

$jobs = $queueModel->getDueQueued(8);

foreach ($jobs as $job) {
    $jobId = (int)$job['id'];
    $results['processed']++;

    if (!$queueModel->markProcessing($jobId)) {
        $results['items'][] = [
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
        $results['failed']++;
        $results['items'][] = [
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
        $results['failed']++;
        $results['items'][] = [
            'id' => $jobId,
            'status' => 'failed',
            'message' => $error,
        ];
        continue;
    }

    $fbPostId = $res['id'] ?? null;
    $queueModel->markPosted($jobId, $fbPostId);

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

    $results['posted']++;
    $results['items'][] = [
        'id' => $jobId,
        'status' => 'posted',
        'fb_post_id' => $fbPostId,
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'cron' => 'queue',
    'results' => $results,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
