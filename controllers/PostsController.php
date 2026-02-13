<?php
class PostsController
{
    public $postModel;
    public $fbService;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->fbService = new FacebookApiService();
    }

    public function index()
    {
        $perPage = 8;
        $page = max(1, (int)($_GET['page'] ?? 1));

        $selectedMenuIds = array_values(array_filter(array_map(
            'intval',
            (array)($_GET['menu_ids'] ?? [])
        )));

        $menuModel = new MenuModel();
        $menus = $menuModel->getAll();

        $total = $this->postModel->countByMenus($selectedMenuIds);
        $totalPages = (int)ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        $posts = $this->postModel->getPageByMenus($perPage, $offset, $selectedMenuIds);

        require_once './views/pages/posts/index.php';
    }

    public function create()
    {
        $pageModel = new FbPageModel();
        $postModel = new PostModel();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $pages = $pageModel->getAll();
            $menus = (new MenuModel())->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        $content = trim($_POST['content'] ?? '');
        $pageIds = $_POST['page_ids'] ?? [];
        $isScheduled = !empty($_POST['is_scheduled']);
        $scheduledAt = $isScheduled ? ($_POST['scheduled_at'] ?? null) : null;
        $menuId = (int)($_POST['menu_id'] ?? 0);

        if ($content === '' && empty($_FILES['media']['name'][0])) {
            set_status('danger', 'Vui lòng nhập nội dung hoặc chọn media.');
            $pages = $pageModel->getAll();
            $menus = (new MenuModel())->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        if (empty($pageIds)) {
            set_status('danger', 'Vui lòng chọn ít nhất 1 page.');
            $pages = $pageModel->getAll();
            $menus = (new MenuModel())->getAll();
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
            if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv'])) $hasVideo = true;
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) $hasImage = true;
        }

        if ($hasVideo && $hasImage) {
            set_status('danger', 'Không thể đăng ảnh và video cùng lúc.');
            $pages = $pageModel->getAll();
            $menus = (new MenuModel())->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        if ($hasVideo && count($mediaFiles) > 1) {
            set_status('danger', 'Chỉ hỗ trợ 1 video mỗi bài.');
            $pages = $pageModel->getAll();
            $menus = (new MenuModel())->getAll();
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
                $res = $this->fbService->postText($pageId, $pageToken, $content, $scheduleTs);

                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $postModel->create([
                        ':menu_id' => $menuId > 0 ? $menuId : null,
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

                    $up = $this->fbService->uploadPhotoUnpublished($pageId, $pageToken, $abs);
                    if (!empty($up['id'])) {
                        $photoIds[] = $up['id'];
                    }
                }

                if (!empty($photoIds)) {
                    $res = $this->fbService->postImages($pageId, $pageToken, $content, $photoIds, $scheduleTs);

                    if (!empty($res['error'])) {
                        $hasError = true;
                        $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                    } else {
                        // lưu DB
                        $mediaPath = count($paths) > 1 ? json_encode($paths) : ($paths[0] ?? null);
                        $postModel->create([
                            ':menu_id' => $menuId > 0 ? $menuId : null,
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
                $res = $this->fbService->postVideo($pageId, $pageToken, $abs, $content, $scheduleTs);

                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $postModel->create([
                        ':menu_id' => $menuId > 0 ? $menuId : null,
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
            $menus = (new MenuModel())->getAll();
            require_once './views/pages/posts/create.php';
            return;
        }

        set_status('success', implode(' | ', $messages));
        header('Location: ?act=posts');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=posts');
            exit;
        }

        $csrf = $_POST['csrf'] ?? '';
        if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            set_status('danger', 'Phiên làm việc không hợp lệ.');
            header('Location: ?act=posts');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            set_status('danger', 'Thiếu id bài.');
            header('Location: ?act=posts');
            exit;
        }

        $post = $this->postModel->getById($id);
        if (!$post || empty($post['fb_post_id'])) {
            set_status('danger', 'Không tìm thấy fb_post_id để xoá.');
            header('Location: ?act=posts');
            exit;
        }

        $pageModel = new FbPageModel();
        $page = $pageModel->getByPageId($post['page_id']);

        if (!$page || empty($page['token_page'])) {
            set_status('danger', 'Thiếu token page.');
            header('Location: ?act=posts');
            exit;
        }

        $res = $this->fbService->deletePost($post['fb_post_id'], $page['token_page']);

        if (!empty($res['error'])) {
            set_status('danger', $res['error']['message'] ?? 'Xoá thất bại.');
            header('Location: ?act=posts');
            exit;
        }

        // Xoá file local nếu có
        $mediaPath = $post['media_path'] ?? null;
        if ($mediaPath) {
            $isJson = is_string($mediaPath) && strlen($mediaPath) > 0 && $mediaPath[0] === '[';
            if ($isJson) {
                $paths = json_decode($mediaPath, true);
                if (is_array($paths)) {
                    foreach ($paths as $p) {
                        deleteFile($p);
                    }
                }
            } else {
                deleteFile($mediaPath);
            }
        }

        // Tuỳ chọn: xoá DB sau khi xoá FB
        $this->postModel->deleteById($id);

        set_status('success', 'Đã xoá bài trên Facebook.');
        header('Location: ?act=posts');
        exit;
    }

    public function repost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=posts');
            exit;
        }

        $csrf = $_POST['csrf'] ?? '';
        if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            set_status('danger', 'Phiên làm việc không hợp lệ.');
            header('Location: ?act=posts');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $pageIds = $_POST['page_ids'] ?? [];

        if ($id <= 0 || empty($pageIds)) {
            set_status('danger', 'Thiếu bài viết hoặc page.');
            header('Location: ?act=posts');
            exit;
        }

        $post = $this->postModel->getById($id);
        if (!$post) {
            set_status('danger', 'Không tìm thấy bài viết.');
            header('Location: ?act=posts');
            exit;
        }

        $pageModel = new FbPageModel();
        $pages = $pageModel->getByPageIds($pageIds);

        $content = $post['content'];
        $mediaType = $post['media_type'];
        $mediaPath = $post['media_path'];

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

            // Text only
            if ($mediaType === 'none' || empty($mediaPath)) {
                $res = $this->fbService->postText($pageId, $pageToken, $content, null);
                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $this->postModel->create([
                        ':menu_id' => $post['menu_id'] ?? null,
                        ':page_id' => $pageId,
                        ':fb_post_id' => $res['id'] ?? null,
                        ':content' => $content,
                        ':media_type' => 'none',
                        ':media_path' => null,
                        ':status' => 'posted',
                        ':scheduled_at' => null,
                        ':posted_at' => date('Y-m-d H:i:s'),
                    ]);
                    $messages[] = "{$pageId}: ok";
                }
                continue;
            }

            // Image(s)
            if ($mediaType === 'image') {
                $paths = null;
                if (is_string($mediaPath) && strlen($mediaPath) > 0 && $mediaPath[0] === '[') {
                    $paths = json_decode($mediaPath, true);
                }
                $list = is_array($paths) ? $paths : [$mediaPath];
                $photoIds = [];

                foreach ($list as $mp) {
                    $abs = PATH_ROOT . $mp;
                    if (!file_exists($abs)) {
                        $hasError = true;
                        $messages[] = "{$pageId}: thiếu file ảnh";
                        continue 2;
                    }
                    $up = $this->fbService->uploadPhotoUnpublished($pageId, $pageToken, $abs);
                    if (!empty($up['id'])) $photoIds[] = $up['id'];
                }

                if (empty($photoIds)) {
                    $hasError = true;
                    $messages[] = "{$pageId}: upload ảnh thất bại";
                    continue;
                }

                $res = $this->fbService->postImages($pageId, $pageToken, $content, $photoIds, null);
                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $this->postModel->create([
                        ':menu_id' => $post['menu_id'] ?? null,
                        ':page_id' => $pageId,
                        ':fb_post_id' => $res['id'] ?? null,
                        ':content' => $content,
                        ':media_type' => 'image',
                        ':media_path' => $mediaPath,
                        ':status' => 'posted',
                        ':scheduled_at' => null,
                        ':posted_at' => date('Y-m-d H:i:s'),
                    ]);
                    $messages[] = "{$pageId}: ok";
                }
                continue;
            }

            // Video
            if ($mediaType === 'video') {
                $abs = PATH_ROOT . $mediaPath;
                if (!file_exists($abs)) {
                    $hasError = true;
                    $messages[] = "{$pageId}: thiếu file video";
                    continue;
                }

                $res = $this->fbService->postVideo($pageId, $pageToken, $abs, $content, null);
                if (!empty($res['error'])) {
                    $hasError = true;
                    $messages[] = "{$pageId}: " . ($res['error']['message'] ?? 'error');
                } else {
                    $this->postModel->create([
                        ':menu_id' => $post['menu_id'] ?? null,
                        ':page_id' => $pageId,
                        ':fb_post_id' => $res['id'] ?? null,
                        ':content' => $content,
                        ':media_type' => 'video',
                        ':media_path' => $mediaPath,
                        ':status' => 'posted',
                        ':scheduled_at' => null,
                        ':posted_at' => date('Y-m-d H:i:s'),
                    ]);
                    $messages[] = "{$pageId}: ok";
                }
                continue;
            }
        }

        if ($hasError) {
            set_status('danger', implode(' | ', $messages));
        } else {
            set_status('success', implode(' | ', $messages));
        }

        header('Location: ?act=posts');
        exit;
    }
}