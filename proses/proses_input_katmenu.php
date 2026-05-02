<?php
include("connect.php");
$jenismenu = (isset($_POST['jenismenu'])) ? htmlentities($_POST['jenismenu']) : '';
$katmenu = (isset($_POST['katmenu'])) ? htmlentities($_POST['katmenu']) : '';

if (!empty($_POST['input_katmenu_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_kategori_menu WHERE kategori_menu='$katmenu'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori menu sudah digunakan!"); window.location = "../katmenu";</script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_kategori_menu VALUES (NULL,'$jenismenu','$katmenu')");
        if ($query) {
            $message = '<script>alert("Data kategori menu berhasil ditambahkan!"); window.location = "../katmenu";</script>';
        } else {
            $message = '<script>alert("Data kategori menu gagal ditambahkan!"); window.location = "../katmenu";</script>';
        }
    }
}
echo $message;
?>