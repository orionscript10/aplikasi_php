<?php
session_start();
include("connect.php");
$message = '';
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';
$password_lama = (isset($_POST['password_lama'])) ? htmlentities($_POST['password_lama']) : '';
$password_baru = (isset($_POST['password_baru'])) ? htmlentities($_POST['password_baru']) : '';
$repassword_baru = (isset($_POST['repassword_baru'])) ? htmlentities($_POST['repassword_baru']) : '';

if (!empty($_POST['ubah_password_validate'])) {
    // Validasi input tidak kosong
    if (empty($password_lama) || empty($password_baru) || empty($repassword_baru)) {
        $message = '<script>alert("Semua field harus diisi!"); window.location.href = "../home";</script>';
    } elseif ($password_baru !== $repassword_baru) {
        // Cek kesamaan password baru sebelum hashing
        $message = '<script>alert("Password baru dan konfirmasi tidak cocok!"); window.location.href = "../home";</script>';
    } else {
        // Hash password untuk query
        $password_lama_md5 = md5($password_lama);
        $password_baru_md5 = md5($password_baru);

        // Cek password lama dari database
        $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$_SESSION[username_recafe]' AND password='$password_lama_md5'");
        $hasil = mysqli_fetch_array($query);

        if ($hasil) {
            // Update password
            $query_update = mysqli_query($conn, "UPDATE tb_user SET password='$password_baru_md5' WHERE id='$id'");
            if ($query_update) {
                $message = '<script>alert("Password berhasil diupdate!"); window.location.href = "../home";</script>';
            } else {
                $message = '<script>alert("Password gagal diupdate! Error: ' . mysqli_error($conn) . '"); window.location.href = "../home";</script>';
            }
        } else {
            $message = '<script>alert("Password lama salah!"); window.location.href = "../home";</script>';
        }
    }
} else {
    $message = '<script>alert("Akses tidak valid!"); window.location.href = "../home";</script>';
}

echo $message;
?>