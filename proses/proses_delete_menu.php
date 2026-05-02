<?php
include("connect.php");
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';
$foto = (isset($_POST['foto'])) ? htmlentities($_POST['foto']) : '';

if (!empty($_POST['input_menu_validate']) && !empty($id)) {
    unlink("../assets/img/$foto");
    $query = mysqli_query($conn, "DELETE FROM tb_daftar_menu WHERE id = '$id'");
    if ($query) {
        $message = '<script>alert("Data menu berhasil dihapus!"); window.location = "../menu";</script>';
    } else {
        $message = '<script>alert("Data menu gagal dihapus!"); window.location = "../menu";</script>';
    }
}
echo $message;
?>