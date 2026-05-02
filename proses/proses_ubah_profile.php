<?php
session_start();
include("connect.php");
$message = '';
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';
$nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : '';
$nohp = (isset($_POST['nohp'])) ? htmlentities($_POST['nohp']) : '';
$alamat = (isset($_POST['alamat'])) ? htmlentities($_POST['alamat']) : '';

if (!empty($_POST['ubah_profile_validate'])) {
    $query_update = mysqli_query($conn, "UPDATE tb_user SET nama='$nama', nohp='$nohp', alamat='$alamat' WHERE id='$id'");
    if ($query_update) {
        $message = '<script>alert("Profile berhasil diupdate!"); window.location.href = "../home";</script>';
    } else {
        $message = '<script>alert("Profile gagal diupdate! Error: ' . mysqli_error($conn) . '"); window.location.href = "../home";</script>';
    }
} else {
    $message = '<script>alert("Akses tidak valid!"); window.location.href = "../home";</script>';
}

echo $message;
?>