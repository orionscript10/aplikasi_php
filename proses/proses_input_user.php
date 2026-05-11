<?php
session_start();
include("connect.php");

if (!empty($_POST['input_user_validate'])) {
    $nama = (isset($_POST['nama'])) ? trim($_POST['nama']) : '';
    $username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
    $level = (isset($_POST['level'])) ? intval($_POST['level']) : 0;
    $nohp = (isset($_POST['nohp'])) ? trim($_POST['nohp']) : '';
    $alamat = (isset($_POST['alamat'])) ? trim($_POST['alamat']) : '';
    
    // Hash the default password
    $default_password = 'password';
    $hashed_password = password_hash($default_password, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO tb_user (nama, username, password, level, nohp, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $nama, $username, $hashed_password, $level, $nohp, $alamat);
    $result = $stmt->execute();
    $stmt->close();
    
    if ($result) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location = '../index.php?x=user';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user!'); window.history.back();</script>";
    }
}
?>
