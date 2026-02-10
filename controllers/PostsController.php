<?php
class PostsController
{
    public $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    public function index()
    {
        $posts = $this->postModel->getAll();
        require_once './views/pages/posts/index.php';
    }

    public function create()
    {
        $pageModel = new FbPageModel();
        $postModel = new PostModel();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $pages = $pageModel->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        $content = trim($_POST['content'] ?? '');
        $pageIds = $_POST['page_ids'] ?? [];
        $isScheduled = !empty($_POST['is_scheduled']);
        $scheduledAt = $isScheduled ? ($_POST['scheduled_at'] ?? null) : null;

        if ($content === '' && empty($_FILES['media']['name'][0])) {
            set_status('danger', 'Vui lòng nhập nội dung hoặc chọn media.');
            $pages = $pageModel->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        if (empty($pageIds)) {
            set_status('danger', 'Vui lòng chọn ít nhất 1 page.');
            $pages = $pageModel->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        $scheduleTs = null;
        if ($isScheduled && $scheduledAt) {
            $dt = new DateTime($scheduledAt, new DateTimeZone('Asia/Ho_Chi_Minh'));
            $scheduleTs = $dt->getTimestamp();
        }

        // lấy file upload
        $mediaFiles = [];
        if (!empty($_FILES['media']) && !empty($_FILES['media']['name'][0])) {
            for ($i = 0; $i < count($_FILES['media']['name']); $i++) {
                $mediaFiles[] = [
                    'name' => $_FILES['media']['name'][$i],
                    'type' => $_FILES['media']['type'][$i],
                    'tmp_name' => $_FILES['media']['tmp_name'][$i],
                    'error' => $_FILES['media']['error'][$i],
                    'size' => $_FILES['media']['size'][$i],
                ];
            }
        }

        $hasVideo = false;
        $hasImage = false;
        foreach ($mediaFiles as $f) {
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['mp4','mov','avi','mkv'])) $hasVideo = true;
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) $hasImage = true;
        }

        if ($hasVideo && $hasImage) {
            set_status('danger', 'Không thể đăng ảnh và video cùng lúc.');
            $pages = $pageModel->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        if ($hasVideo && count($mediaFiles) > 1) {
            set_status('danger', 'Chỉ hỗ trợ 1 video mỗi bài.');
            $pages = $pageModel->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        $pages = $pageModel->getByPageIds($pageIds);

        $hasError = false;
        $messages = [];

        foreach ($pages as $p) {
            $pageId = $p['page_id'];
            $pageToken = $p['token_page'];

            if (!$pageToken) {
                $hasError = true;
                $messages[] = "{$pageId}: thiếu page token";
                continue;
            }

            // CASE 1: Text only
            if (!$hasImage && !$hasVideo) {
                $res = fbPostText($pageId, $pageToken, $content, $scheduleTs);

                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $postModel->create([
                        ':page_id' => $pageId,
                        ':fb_post_id' => $res['id'] ?? null,
                        ':content' => $content,
                        ':media_type' => 'none',
                        ':media_path' => null,
                        ':status' => $scheduleTs ? 'scheduled' : 'posted',
                        ':scheduled_at' => $scheduleTs ? date('Y-m-d H:i:s', $scheduleTs) : null,
                        ':posted_at' => $scheduleTs ? null : date('Y-m-d H:i:s'),
                    ]);

                    $messages[] = "{$pageId}: " . ($res['id'] ?? 'ok');
                }
                continue;
            }

            // CASE 2: Text + nhiều ảnh
            if ($hasImage) {
                $photoIds = [];
                $paths = [];

                foreach ($mediaFiles as $f) {
                    $path = uploadFile($f, 'uploads/posts/');
                    if (!$path) continue;

                    $paths[] = $path;
                    $abs = PATH_ROOT . $path;

                    $up = fbUploadPhotoUnpublished($pageId, $pageToken, $abs);
                    if (!empty($up['id'])) {
                        $photoIds[] = $up['id'];
                    }
                }

                if (!empty($photoIds)) {
                    $res = fbPostImages($pageId, $pageToken, $content, $photoIds, $scheduleTs);

                    if (!empty($res['error'])) {
                        $hasError = true;
                        $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                    } else {
                        // lưu DB
                        $mediaPath = count($paths) > 1 ? json_encode($paths) : ($paths[0] ?? null);
                        $postModel->create([
                            ':page_id' => $pageId,
                            ':fb_post_id' => $res['id'] ?? null,
                            ':content' => $content,
                            ':media_type' => 'image',
                            ':media_path' => $mediaPath,
                            ':status' => $scheduleTs ? 'scheduled' : 'posted',
                            ':scheduled_at' => $scheduleTs ? date('Y-m-d H:i:s', $scheduleTs) : null,
                            ':posted_at' => $scheduleTs ? null : date('Y-m-d H:i:s'),
                        ]);

                        $messages[] = "{$pageId}: " . ($res['id'] ?? 'ok');
                    }
                } else {
                    $hasError = true;
                    $messages[] = "{$pageId}: upload ảnh thất bại";
                }
                continue;
            }

            // CASE 3: Text + 1 video
            if ($hasVideo) {
                $f = $mediaFiles[0];
                $path = uploadFile($f, 'uploads/posts/');
                if (!$path) {
                    $hasError = true;
                    $messages[] = "{$pageId}: upload video thất bại";
                    continue;
                }

                $abs = PATH_ROOT . $path;
                $res = fbPostVideo($pageId, $pageToken, $abs, $content, $scheduleTs);

                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $postModel->create([
                        ':page_id' => $pageId,
                        ':fb_post_id' => $res['id'] ?? null,
                        ':content' => $content,
                        ':media_type' => 'video',
                        ':media_path' => $path,
                        ':status' => $scheduleTs ? 'scheduled' : 'posted',
                        ':scheduled_at' => $scheduleTs ? date('Y-m-d H:i:s', $scheduleTs) : null,
                        ':posted_at' => $scheduleTs ? null : date('Y-m-d H:i:s'),
                    ]);

                    $messages[] = "{$pageId}: " . ($res['id'] ?? 'ok');
                }
            }
        }

        if ($hasError) {
            set_status('danger', implode(' | ', $messages));
            $pages = $pageModel->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        set_status('success', implode(' | ', $messages));
        header('Location: ?act=posts');
        exit;
    }

}