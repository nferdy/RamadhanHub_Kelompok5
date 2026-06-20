<?php
declare(strict_types=1);

// Aktifkan session native PHP
session_start();

$routes = [
    ''            => ['page' => 'dashboard',    'title' => 'Dashboard Ramadhan',     'active' => 'dashboard'],
    'dashboard'   => ['page' => 'dashboard',    'title' => 'Dashboard Ramadhan',     'active' => 'dashboard'],
    'kalender'    => ['page' => 'calendar',     'title' => 'Kalender Ramadhan',      'active' => 'calendar'],
    'puasa'       => ['page' => 'fasting',      'title' => 'Tracker Puasa',          'active' => 'fasting'],
    'sholat'      => ['page' => 'prayer',       'title' => 'Reminder Sholat',        'active' => 'prayer'],
    'quran'       => ['page' => 'quran',        'title' => 'Al-Quran Progress',      'active' => 'quran'],
    'achievement' => ['page' => 'achievements', 'title' => 'Achievement Ramadhan',   'active' => 'achievement'],
    'login'       => ['page' => 'login',        'title' => 'Login - Ramadhan HUB',   'active' => 'login'],
    'register'    => ['page' => 'register',     'title' => 'Daftar - Ramadhan HUB',  'active' => 'login'],

    'admin/users'        => ['page' => 'users_mgt', 'title' => 'Kelola User', 'active' => 'users_mgt'],
    'admin/users/add'    => ['page' => 'users_mgt', 'title' => 'Tambah User', 'active' => 'users_mgt'],
    'admin/users/edit'   => ['page' => 'edit_user', 'title' => 'Edit User',   'active' => 'users_mgt'],
    'admin/users/delete' => ['page' => 'users_mgt', 'title' => 'Hapus User',  'active' => 'users_mgt']
];

function app_request_path(): string
{
    $pathInfo = $_SERVER['PATH_INFO'] ?? '';
    if ($pathInfo !== '') return trim($pathInfo, '/');
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $baseDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($scriptName !== '' && strpos($requestPath, $scriptName) === 0) {
        $requestPath = substr($requestPath, strlen($scriptName));
    } elseif ($baseDir !== '' && $baseDir !== '/' && strpos($requestPath, $baseDir) === 0) {
        $requestPath = substr($requestPath, strlen($baseDir));
    }
    $requestPath = trim($requestPath, '/');
    if (strpos($requestPath, 'index.php/') === 0) $requestPath = substr($requestPath, strlen('index.php/'));
    if ($requestPath === 'index.php') $requestPath = '';
    return trim($requestPath, '/');
}

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string {
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
        $basePath = ($basePath === '' || $basePath === '/') ? '' : $basePath;
        return $basePath . '/' . ltrim($path, '/');
    }
}

if (!function_exists('site_url')) {
    function site_url(string $path = ''): string {
        $path = trim($path, '/');
        return rtrim(base_url('index.php' . ($path !== '' ? '/' . $path : '')), '/');
    }
}

if (!function_exists('html_escape')) {
    function html_escape($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

$routeKey = app_request_path();

// --- LOGIKA AUTENTIKASI ---

// 1. Proses Logout
if ($routeKey === 'auth/logout' || $routeKey === 'logout') {
    session_destroy();
    header("Location: " . site_url('login'));
    exit;
}

// 2. Proses Validasi Login (POST)
if ($routeKey === 'auth/process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $db = new mysqli('localhost', 'root', '', 'ramadhan_v1');
    $stmt = $db->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        header("Location: " . site_url('dashboard'));
        exit;
    } else {
        $_SESSION['error'] = 'Username atau password salah!';
        header("Location: " . site_url('login'));
        exit;
    }
}

// 3. Proses Register (POST)
if ($routeKey === 'auth/register_process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $db = new mysqli('localhost', 'root', '', 'ramadhan_v1');
    
    // Cek apakah username sudah ada
    $stmt_check = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        $_SESSION['error'] = 'Username sudah digunakan!';
        header("Location: " . site_url('register'));
        exit;
    }

    // Insert user baru
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt_insert = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    $stmt_insert->bind_param("ss", $username, $hashed_password);
    if ($stmt_insert->execute()) {
        $_SESSION['success'] = 'Akun berhasil dibuat! Silakan login.';
        header("Location: " . site_url('login'));
        exit;
    }
}

// 4. Proteksi Halaman (Redirect ke login jika belum login)
$public_routes = ['login', 'auth/process', 'register', 'auth/register_process'];
if (!isset($_SESSION['logged_in']) && !in_array($routeKey, $public_routes)) {
    header("Location: " . site_url('login'));
    exit;
}

// --- AKHIR LOGIKA AUTENTIKASI ---

if (!isset($routes[$routeKey])) {
    http_response_code(404);
    $routeKey = 'dashboard';
    $not_found = true;
}

$route = $routes[$routeKey];
$page_title = $route['title'];
$active_menu = $route['active'];
$content = 'pages/' . $route['page'];
$content_file = __DIR__ . '/application/views/pages/' . $route['page'] . '.php';

// --- LOGIKA PENGAMBILAN DATA SPESIFIK HALAMAN & CRUD ADMIN ---
$users_data = [];
$edit_user_data = null;

// Cek Keamanan: Pastikan hanya Admin yang bisa akses rute admin/*
if (strpos($routeKey, 'admin/') === 0) {
    if (($_SESSION['role'] ?? '') !== 'admin') {
        header("Location: " . site_url('dashboard'));
        exit;
    }
    $db = new mysqli('localhost', 'root', '', 'ramadhan_v1');

    // [C] CREATE: Tambah User Baru
    if ($routeKey === 'admin/users/add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $_SESSION['error'] = 'Username sudah digunakan!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hash, $role);
            if ($stmt->execute()) $_SESSION['success'] = 'User baru berhasil ditambahkan!';
        }
        header("Location: " . site_url('admin/users'));
        exit;
    }

    // [U] UPDATE: Edit User
    if ($routeKey === 'admin/users/edit') {
        $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $role = $_POST['role'] ?? 'user';
            $password = $_POST['password'] ?? '';

            if (!empty($password)) { // Jika password diisi, update juga passwordnya
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET username=?, role=?, password=? WHERE id=?");
                $stmt->bind_param("sssi", $username, $role, $hash, $id);
            } else { // Jika dikosongkan, biarkan password lama
                $stmt = $db->prepare("UPDATE users SET username=?, role=? WHERE id=?");
                $stmt->bind_param("ssi", $username, $role, $id);
            }
            if ($stmt->execute()) $_SESSION['success'] = 'Data user berhasil diperbarui!';
            header("Location: " . site_url('admin/users'));
            exit;
        } else {
            // GET request untuk menampilkan form edit
            $stmt = $db->prepare("SELECT id, username, role FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $edit_user_data = $stmt->get_result()->fetch_assoc();
            if (!$edit_user_data) {
                $_SESSION['error'] = 'User tidak ditemukan!';
                header("Location: " . site_url('admin/users'));
                exit;
            }
        }
    }

    // [D] DELETE: Hapus User
    if ($routeKey === 'admin/users/delete') {
        $id = (int)($_GET['id'] ?? 0);
        if ($id === (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Tidak bisa menghapus akun yang sedang Anda gunakan!';
        } else {
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) $_SESSION['success'] = 'Akun berhasil dihapus permanen!';
        }
        header("Location: " . site_url('admin/users'));
        exit;
    }

    // [R] READ: Tampilkan Daftar User (Hanya dieksekusi di halaman utama Kelola User)
    if ($routeKey === 'admin/users') {
        $result = $db->query("SELECT id, username, role FROM users ORDER BY id ASC");
        while ($row = $result->fetch_assoc()) $users_data[] = $row;
    }
}

// Set variabel pesan notifikasi
$flash_error = $_SESSION['error'] ?? null;
$flash_success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']); // Hapus supaya tidak muncul terus

// Render HTML
require __DIR__ . '/application/views/layouts/main.php';
