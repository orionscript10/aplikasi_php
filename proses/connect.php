<?php
// Read environment variables or use defaults
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'db_recafe';

// For Railway: Parse database URL if available
if (getenv('DATABASE_URL')) {
    $db_url = parse_url(getenv('DATABASE_URL'));
    $db_host = $db_url['host'];
    $db_user = $db_url['user'];
    $db_password = $db_url['pass'];
    $db_name = ltrim($db_url['path'], '/');
}

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Gagal Koneksi: " . mysqli_connect_error());
}
?>
