<?php 
// Harden session cookie
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

// Require file Common
require_once './commons/env.php';
require_once './commons/function.php';

// Require Controllers
require_once './controllers/ProductController.php';
require_once './controllers/LoginController.php';

// Require Models
require_once './models/BaseModel.php';
require_once './models/ProductModel.php';
require_once './models/AdminModel.php';

$act = $_GET['act'] ?? '/';

if (!isset($_SESSION['user']) && !in_array($act, ['login', 'logout'], true)) {
    header('Location: ?act=login');
    exit;
}

match ($act) {
    '/'       => (new ProductController())->Home(),
    'login'   => (new LoginController())->login(),   // GET show + POST handle
    'logout'  => (new LoginController())->logout(),
    default   => (new ProductController())->Home(),
};