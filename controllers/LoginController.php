<?php
class LoginController
{
    public $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function login()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                $error = 'Vui lòng nhập đủ tài khoản và mật khẩu.';
                require_once './views/pages/login.php';
                return;
            }

            $admin = $this->adminModel->findByUsername($username);
            if (!$admin) {
                $error = 'Tài khoản không tồn tại.';
                require_once './views/pages/login.php';
                return;
            }

            if (!password_verify($password, $admin['password'])) {
                $error = 'Mật khẩu không đúng.';
                require_once './views/pages/login.php';
                return;
            }

            $_SESSION['user'] = [
                'id' => $admin['id'],
                'username' => $admin['username']
            ];
            
            header('Location: ?act=login&msg=login_ok');
            exit;
        }

        require_once './views/pages/login.php';
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ?act=login&msg=logout');
        exit;
    }

}