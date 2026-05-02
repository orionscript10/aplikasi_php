<?php
include("connect.php");
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';

if (!empty($_POST['hapus_katmenu_validate']) && !empty($id)) {
    $select = mysqli_query($conn, "SELECT kategori FROM tb_daftar_menu WHERE kategori ='$id'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori menu masih digunakan oleh menu lain!"); window.location = "../katmenu";</script>';
    } else {
        $query = mysqli_query($conn, "DELETE FROM tb_kategori_menu WHERE id_kat_menu = '$id'");
        if ($query) {
            $message = '<script>alert("Data kategori menu berhasil dihapus!"); window.location = "../katmenu";</script>';
        } else {
            $message = '<script>alert("Data kategori menu gagal dihapus!"); window.location = "../katmenu";</script>';
        }
    }
}
echo $message;
?>