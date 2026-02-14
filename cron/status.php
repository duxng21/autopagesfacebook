<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
initDatabaseSchemaIfNeeded();

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/PostModel.php';

$postModel = new PostModel();
$postModel->markScheduledToPosted();

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'cron' => 'status',
    'message' => 'scheduled -> posted updated',
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
