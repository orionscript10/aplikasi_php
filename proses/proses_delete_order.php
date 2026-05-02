<?php
include("connect.php");
$kode_order = (isset($_POST['kode_order'])) ? htmlentities($_POST['kode_order']) : '';

if (!empty($_POST['delete_order_validate']) && !empty($kode_order)) {
    $select = mysqli_query($conn, "SELECT * FROM tb_list_order WHERE kode_order ='$kode_order'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Order tidak dapat dihapus karena masih memiliki item order!"); window.location = "../orders";</script>';
    } else {
        $query = mysqli_query($conn, "DELETE FROM tb_order WHERE id_order = '$kode_order'");
        if ($query) {
            $message = '<script>alert("Order berhasil dihapus!"); window.location = "../orders";</script>';
        } else {
            $message = '<script>alert("Order gagal dihapus!"); window.location = "../orders";</script>';
        }
    }
}
echo $message;
?>