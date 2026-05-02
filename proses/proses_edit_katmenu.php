<?php
include("connect.php");
$id_kat_menu = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';
$jenismenu = (isset($_POST['jenismenu'])) ? htmlentities($_POST['jenismenu']) : '';
$katmenu = (isset($_POST['katmenu'])) ? htmlentities($_POST['katmenu']) : '';

if (!empty($_POST['edit_katmenu_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_kategori_menu WHERE kategori_menu='$katmenu' AND id_kat_menu != '$id_kat_menu'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori menu sudah ada!"); window.location = "../katmenu";</script>';
    } else {
        $query = mysqli_query($conn, "UPDATE tb_kategori_menu SET jenis_menu='$jenismenu', kategori_menu='$katmenu' WHERE id_kat_menu='$id_kat_menu'");
        if ($query) {
            $message = '<script>alert("Data kategori menu berhasil diupdate!"); window.location = "../katmenu";</script>';
        } else {
            $message = '<script>alert("Data kategori menu gagal diupdate!"); window.location = "../katmenu";</script>';
        }
    }
}
echo $message;
?>