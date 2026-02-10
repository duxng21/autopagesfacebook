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

        if (!isset($_SESSION['login_fail'])) {
            $_SESSION['login_fail'] = 0;
            $_SESSION['login_fail_time'] = time();
        }

        // cooldown 5 phút nếu sai >=5 lần
        if ($_SESSION['login_fail'] >= 5 && (time() - $_SESSION['login_fail_time']) < 300) {
            $error = 'Bạn đăng nhập sai quá nhiều. Vui lòng thử lại sau 5 phút.';
            require_once './views/pages/login.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['csrf'] ?? '';
            if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
                $error = 'Phiên làm việc không hợp lệ.';
                require_once './views/pages/login.php';
                return;
            }

            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                $error = 'Vui lòng nhập đủ tài khoản và mật khẩu.';
                require_once './views/pages/login.php';
                return;
            }

            $admin = $this->adminModel->findByUsername($username);
            if (!$admin) {
                $_SESSION['login_fail']++;
                $_SESSION['login_fail_time'] = time();

                $error = 'Tài khoản không tồn tại.';
                require_once './views/pages/login.php';
                return;
            }

            if (!password_verify($password, $admin['password'])) {
                $_SESSION['login_fail']++;
                $_SESSION['login_fail_time'] = time();

                $error = 'Mật khẩu không đúng.';
                require_once './views/pages/login.php';
                return;
            }

            session_regenerate_id(true);

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