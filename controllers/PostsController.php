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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once './views/pages/posts/create.php';
            return;
        }

        $content = trim($_POST['content'] ?? '');
        $isScheduled = !empty($_POST['is_scheduled']);
        $scheduledAt = $isScheduled ? ($_POST['scheduled_at'] ?? null) : null;

        if ($content === '') {
            set_status('danger', 'Vui lòng nhập nội dung.');
            require_once './views/pages/posts/create.php';
            return;
        }

        $mediaType = 'none';
        $mediaPath = null;

        if (!empty($_FILES['media']) && !empty($_FILES['media']['name'][0])) {
            $file = [
                'name' => $_FILES['media']['name'][0],
                'type' => $_FILES['media']['type'][0],
                'tmp_name' => $_FILES['media']['tmp_name'][0],
                'error' => $_FILES['media']['error'][0],
                'size' => $_FILES['media']['size'][0],
            ];

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $mediaType = 'image';
            } elseif (in_array($ext, ['mp4','mov','avi','mkv'])) {
                $mediaType = 'video';
            }

            $mediaPath = uploadFile($file, 'uploads/posts/');
        }

        $status = $isScheduled ? 'scheduled' : 'draft';

        $ok = $this->postModel->create([
            ':page_id' => null,
            ':fb_post_id' => null,
            ':content' => $content,
            ':media_type' => $mediaType,
            ':media_path' => $mediaPath,
            ':status' => $status,
            ':scheduled_at' => $scheduledAt,
            ':posted_at' => null,
        ]);

        if ($ok) {
            set_status('success', 'Đã tạo bài viết.');
            header('Location: ?act=posts');
            exit;
        }

        set_status('danger', 'Tạo bài viết thất bại.');
        require_once './views/pages/posts/create.php';
    }
}