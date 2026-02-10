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
    $pathSave = PATH_ROOT . $pathStorage; // Đường dãn tuyệt đối của file

    if (move_uploaded_file($tmp_file, $pathSave)) {
        return $pathStorage;
    }
    return null;
}

function deleteFile($file){
    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete); // Hàm unlink dùng để xóa file
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

function fbApiPost(string $url, array $params, bool $isMultipart = false): array
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    if ($isMultipart) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    } else {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    }

    $raw = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        return ['error' => ['message' => $err]];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : ['error' => ['message' => 'Invalid JSON']];
}

function fbGraphVersion(): string
{
    return defined('FB_GRAPH_VERSION') ? FB_GRAPH_VERSION : 'v18.0';
}

function fbPostText(string $pageId, string $pageToken, string $message, ?int $scheduleTs = null): array
{
    $url = "https://graph.facebook.com/" . fbGraphVersion() . "/{$pageId}/feed";

    $params = [
        'message' => $message,
        'access_token' => $pageToken,
    ];

    if ($scheduleTs) {
        $params['published'] = 'false';
        $params['scheduled_publish_time'] = $scheduleTs;
    }

    return fbApiPost($url, $params);
}

function fbUploadPhotoUnpublished(string $pageId, string $pageToken, string $absPath): array
{
    $url = "https://graph.facebook.com/" . fbGraphVersion() . "/{$pageId}/photos";

    $params = [
        'access_token' => $pageToken,
        'published' => 'false',
        'source' => new CURLFile($absPath),
    ];

    return fbApiPost($url, $params, true);
}

function fbPostImages(string $pageId, string $pageToken, string $message, array $photoIds, ?int $scheduleTs = null): array
{
    $url = "https://graph.facebook.com/" . fbGraphVersion() . "/{$pageId}/feed";

    $attached = [];
    foreach ($photoIds as $id) {
        $attached[] = ['media_fbid' => $id];
    }

    $params = [
        'message' => $message,
        'attached_media' => json_encode($attached),
        'access_token' => $pageToken,
    ];

    if ($scheduleTs) {
        $params['published'] = 'false';
        $params['scheduled_publish_time'] = $scheduleTs;
    }

    return fbApiPost($url, $params);
}

function fbPostVideo(string $pageId, string $pageToken, string $absPath, string $message = '', ?int $scheduleTs = null): array
{
    $url = "https://graph.facebook.com/" . fbGraphVersion() . "/{$pageId}/videos";

    $params = [
        'access_token' => $pageToken,
        'description' => $message,
        'source' => new CURLFile($absPath),
    ];

    if ($scheduleTs) {
        $params['published'] = 'false';
        $params['scheduled_publish_time'] = $scheduleTs;
    }

    return fbApiPost($url, $params, true);
}