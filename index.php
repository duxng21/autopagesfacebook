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
require_once './controllers/PagesController.php';
require_once './controllers/PostsController.php';
require_once './controllers/MenusController.php';
require_once './services/FacebookApiService.php';

// Require Models
require_once './models/BaseModel.php';
require_once './models/ProductModel.php';
require_once './models/AdminModel.php';
require_once './models/FbPageModel.php';
require_once './models/PostModel.php';
require_once './models/MenuModel.php';

$act = $_GET['act'] ?? '/';

if (!isset($_SESSION['user']) && !in_array($act, ['login', 'logout'], true)) {
    header('Location: ?act=login');
    exit;
}

match ($act) {
    '/'       => (new ProductController())->Home(),
    'login'   => (new LoginController())->login(),   // GET show + POST handle
    'logout'  => (new LoginController())->logout(),
    'pages'   => ($_SERVER['REQUEST_METHOD'] === 'POST')
        ? (new PagesController())->store()
        : (new PagesController())->index(),
    'pages-delete' => (new PagesController())->delete(),
    'posts'   => (new PostsController())->index(),
    'post-add'=> (new PostsController())->create(),
    'post-delete' => (new PostsController())->delete(),
    'post-repost' => (new PostsController())->repost(),
    'menus' => (new MenusController())->index(),
    'menu-add' => (new MenusController())->create(),
    'menu-edit' => (new MenusController())->edit(),
    'menu-delete' => (new MenusController())->delete(),
    default   => (new ProductController())->Home(),
};