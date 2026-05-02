<?php
include("connect.php");
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';

if (!empty($_POST['input_user_validate']) && !empty($id)) {
    $query = mysqli_query($conn, "DELETE FROM tb_user WHERE id = '$id'");
    if ($query) {
        $message = '<script>alert("User berhasil dihapus!"); window.location = "../user";</script>';
    } else {
        $message = '<script>alert("User gagal dihapus!"); window.location = "../user";</script>';
    }
}
echo $message;
?>