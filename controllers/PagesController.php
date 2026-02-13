<?php
class PagesController
{
    public $pageModel;
    public $fbService;

    public function __construct()
    {
        $this->pageModel = new FbPageModel();
        $this->fbService = new FacebookApiService();
    }

    public function index()
    {
        $pages = $this->pageModel->getAll();
        require_once './views/pages/pages.php';
    }

    public function store()
    {
        $userToken = trim($_POST['user_token'] ?? '');
        if ($userToken === '') {
            set_status('danger', 'Vui lòng nhập User Access Token.');
            $pages = $this->pageModel->getAll();
            require_once './views/pages/pages.php';
            return;
        }

        $result = $this->fetchUserPages($userToken);
        if (!empty($result['error'])) {
            $message = $result['error']['message'] ?? 'Token không hợp lệ hoặc hết hạn.';
            set_status('danger', $message);
            $pages = $this->pageModel->getAll();
            require_once './views/pages/pages.php';
            return;
        }

        $count = 0;
        foreach (($result['data'] ?? []) as $page) {
            $this->pageModel->upsertFromGraph($userToken, $page);
            $count++;
        }

        set_status('success', "Đã cập nhật {$count} page.");
        header('Location: ?act=pages');
        exit;
    }

    private function fetchUserPages(string $userToken): array
    {
        return $this->fbService->getUserPages($userToken);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=pages');
            exit;
        }

        $csrf = $_POST['csrf'] ?? '';
        if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            set_status('danger', 'Phiên làm việc không hợp lệ.');
            header('Location: ?act=pages');
            exit;
        }

        $pageId = trim($_POST['page_id'] ?? '');
        if ($pageId === '') {
            set_status('danger', 'Thiếu page_id.');
            header('Location: ?act=pages');
            exit;
        }

        $ok = $this->pageModel->deleteByPageId($pageId);
        set_status($ok ? 'success' : 'danger', $ok ? 'Đã xoá page.' : 'Xoá thất bại.');

        header('Location: ?act=pages');
        exit;
    }

}