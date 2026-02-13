<?php
require_once './commons/env.php';
require_once './commons/function.php';
require_once './models/BaseModel.php';
require_once './models/FbPageModel.php';
require_once './models/PostModel.php';
require_once './services/FacebookApiService.php';

// ===== Cron: cập nhật token page =====
$model = new FbPageModel();
$pages = $model->getAll();
$results = [];
$fbService = new FacebookApiService();

foreach ($pages as $p) {
    $pageId = $p['page_id'];
    $userToken = $p['access_token']; // user token lưu trong fb_pages

    if (!$pageId || !$userToken) {
        $results[] = ['page_id' => $pageId, 'status' => 'skip', 'message' => 'missing token'];
        continue;
    }

    $data = $fbService->getPageInfo($pageId, $userToken);

    if (!empty($data['error'])) {
        $results[] = [
            'page_id' => $pageId,
            'status' => 'error',
            'message' => $data['error']['message'] ?? 'unknown'
        ];
        continue;
    }

    $name = $data['name'] ?? '';
    $pageToken = $data['access_token'] ?? '';
    $avatar = $data['picture']['data']['url'] ?? ("https://graph.facebook.com/{$pageId}/picture?type=square");

    $ok = $model->updatePageInfo($pageId, $name, $avatar, $pageToken);
    $results[] = [
        'page_id' => $pageId,
        'status' => $ok ? 'updated' : 'failed'
    ];
}

// ===== Cron: cập nhật trạng thái bài lên lịch (giờ VN) =====
$postModel = new PostModel();
$postModel->markScheduledToPosted();

// ===== Output =====
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => true, 'results' => $results], JSON_PRETTY_PRINT);