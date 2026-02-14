<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
initDatabaseSchemaIfNeeded();

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/FbPageModel.php';
require_once __DIR__ . '/../services/FacebookApiService.php';

$fbService = new FacebookApiService();
$pageModel = new FbPageModel();

$results = [];
$pages = $pageModel->getAll();

foreach ($pages as $p) {
    $pageId = $p['page_id'];
    $userToken = $p['access_token'];

    if (!$pageId || !$userToken) {
        $results[] = [
            'page_id' => $pageId,
            'status' => 'skip',
            'message' => 'missing token',
        ];
        continue;
    }

    $data = $fbService->getPageInfo($pageId, $userToken);

    if (!empty($data['error'])) {
        $results[] = [
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
    $results[] = [
        'page_id' => $pageId,
        'status' => $ok ? 'updated' : 'failed',
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'cron' => 'token',
    'results' => $results,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
