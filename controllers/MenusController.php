<?php
class MenusController
{
    public $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        $menus = $this->menuModel->getAll();
        require_once './views/pages/menus/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=menus');
            exit;
        }

        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            set_status('danger', 'Tên danh mục là bắt buộc.');
            header('Location: ?act=menus');
            exit;
        }

        $ok = $this->menuModel->create($name);
        set_status($ok ? 'success' : 'danger', $ok ? 'Tạo danh mục thành công.' : 'Tạo danh mục thất bại.');
        header('Location: ?act=menus');
        exit;
    }

    public function edit()
    {
        $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        if ($id <= 0) {
            set_status('danger', 'Thiếu id danh mục.');
            header('Location: ?act=menus');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $menu = $this->menuModel->getById($id);
            if (!$menu) {
                set_status('danger', 'Không tìm thấy danh mục.');
                header('Location: ?act=menus');
                exit;
            }
            require_once './views/pages/menus/edit.php';
            return;
        }

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            set_status('danger', 'Tên danh mục là bắt buộc.');
            $menu = $this->menuModel->getById($id);
            require_once './views/pages/menus/edit.php';
            return;
        }

        $ok = $this->menuModel->update($id, $name);
        set_status($ok ? 'success' : 'danger', $ok ? 'Cập nhật danh mục thành công.' : 'Cập nhật danh mục thất bại.');
        header('Location: ?act=menus');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=menus');
            exit;
        }

        $csrf = $_POST['csrf'] ?? '';
        if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            set_status('danger', 'Phiên làm việc không hợp lệ.');
            header('Location: ?act=menus');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            set_status('danger', 'Thiếu id danh mục.');
            header('Location: ?act=menus');
            exit;
        }

        $ok = $this->menuModel->delete($id);
        set_status($ok ? 'success' : 'danger', $ok ? 'Xóa danh mục thành công.' : 'Xóa danh mục thất bại.');
        header('Location: ?act=menus');
        exit;
    }
}