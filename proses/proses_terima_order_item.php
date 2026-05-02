<?php
include("connect.php");
$catatan = (isset($_POST['catatan'])) ? htmlentities($_POST['catatan']) : '';
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';


if (!empty($_POST['terima_order_validate'])) {
    $query = mysqli_query($conn, "UPDATE tb_list_order SET catatan='$catatan', status='1' WHERE id_list_order='$id'");
    if ($query) {
        $message = '<script>alert("Berhasil diterima!"); window.location = "../dapur";</script>';
    } else {
        $message = '<script>alert("Dapur gagal diterima!"); window.location = "../dapur";</script>';
    }
}
echo $message;
?>