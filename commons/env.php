<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

define('BASE_URL'       , 'http://localhost/code3');
define('TITLE_BASE'       , 'Hệ thống quản lý Pages Facebook');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'code_2');  // Tên database
define('FB_GRAPH_VERSION', 'v19.0');
define('PATH_ROOT'    , __DIR__ . '/../');
