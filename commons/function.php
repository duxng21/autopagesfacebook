<?php

// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

function uploadFile($file, $folderSave){
    $file_upload = $file;
    $pathStorage = $folderSave . rand(10000, 99999) . $file_upload['name'];

    $tmp_file = $file_upload['tmp_name'];
    $pathSave = PATH_ROOT . $pathStorage; // Đường dẫn tuyệt đối của file

    if (move_uploaded_file($tmp_file, $pathSave)) {
        return $pathStorage;
    }
    return null;
}

function deleteFile($file){
    if (!$file) return; // không có file thì bỏ qua
    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete);
    }
}

function menu_active($act)
{
    $current = $_GET['act'] ?? '/';
    return $current === $act ? 'active' : '';
}

function set_status(string $type, string $message)
{
    $_SESSION['status'] = [
        'type' => $type,     // success | danger | warning | info
        'message' => $message
    ];
}

function show_status()
{
    if (!empty($_SESSION['status'])) {
        $type = $_SESSION['status']['type'] ?? 'info';
        $message = $_SESSION['status']['message'] ?? '';
        unset($_SESSION['status']);

        if ($message !== '') {
            echo '<div class="alert alert-' . htmlspecialchars($type) . '">';
            echo htmlspecialchars($message);
            echo '</div>';
        }
    }
}

function initDatabaseSchemaIfNeeded(): void
{
    if (!defined('DB_AUTO_INIT') || DB_AUTO_INIT !== true) return;

    static $inited = false;
    if ($inited) return;
    $inited = true;

    $conn = connectDB();
    if (!$conn) return;

    // MariaDB friendly collation
    $collate = "utf8mb4_unicode_ci";

    $conn->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY username (username)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE={$collate}
    ");

    $conn->exec("
        CREATE TABLE IF NOT EXISTS fb_pages (
            id INT NOT NULL AUTO_INCREMENT,
            page_id VARCHAR(50) NOT NULL,
            page_name VARCHAR(255) NOT NULL,
            page_avatar TEXT DEFAULT NULL,
            access_token TEXT NOT NULL,
            token_page TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY page_id (page_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE={$collate}
    ");

    $conn->exec("
        CREATE TABLE IF NOT EXISTS menus (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(150) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY uniq_menu_name (name)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE={$collate}
    ");

    $conn->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id INT NOT NULL AUTO_INCREMENT,
            page_id VARCHAR(50) DEFAULT NULL,
            menu_id INT DEFAULT NULL,
            fb_post_id VARCHAR(100) DEFAULT NULL,
            content TEXT NOT NULL,
            media_type ENUM('image','video','none') DEFAULT 'none',
            media_path VARCHAR(255) DEFAULT NULL,
            status ENUM('draft','scheduled','posted') DEFAULT 'draft',
            scheduled_at DATETIME DEFAULT NULL,
            posted_at DATETIME DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_posts_menu_id (menu_id),
            CONSTRAINT fk_posts_menu_id FOREIGN KEY (menu_id)
                REFERENCES menus (id) ON DELETE SET NULL ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE={$collate}
    ");

    $conn->exec("
        CREATE TABLE IF NOT EXISTS post_queue (
            id INT NOT NULL AUTO_INCREMENT,
            batch_id VARCHAR(40) NOT NULL,
            source_no INT NOT NULL,
            page_id VARCHAR(50) NOT NULL,
            menu_id INT DEFAULT NULL,
            content TEXT DEFAULT NULL,
            media_type ENUM('image','video','none') DEFAULT 'none',
            media_path TEXT DEFAULT NULL,
            scheduled_at DATETIME NOT NULL,
            status ENUM('queued','processing','posted','failed','cancelled') DEFAULT 'queued',
            fb_post_id VARCHAR(100) DEFAULT NULL,
            retry_count INT DEFAULT 0,
            last_error TEXT DEFAULT NULL,
            last_attempt_at DATETIME DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_queue_status_time (status, scheduled_at),
            KEY idx_queue_page (page_id),
            KEY idx_batch_id (batch_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE={$collate}
    ");

    // seed admin mặc định nếu chưa có
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = :u LIMIT 1");
    $stmt->execute([':u' => DEFAULT_ADMIN_USER]);
    $exists = $stmt->fetch();

    if (!$exists) {
        $ins = $conn->prepare("
            INSERT INTO admins (username, password)
            VALUES (:u, :p)
        ");
        $ins->execute([
            ':u' => DEFAULT_ADMIN_USER,
            ':p' => DEFAULT_ADMIN_HASH
        ]);
    }
}