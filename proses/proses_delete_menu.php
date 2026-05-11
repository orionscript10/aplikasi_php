<?php
include("connect.php");
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';
$foto = (isset($_POST['foto'])) ? htmlentities($_POST['foto']) : '';

if (!empty($_POST['input_menu_validate']) && !empty($id)) {
    // Hapus file foto jika ada
    $file_path = "../assets/img/$foto";
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Delete dari database
    $query = mysqli_query($conn, "DELETE FROM tb_daftar_menu WHERE id = '$id'");
    if ($query) {
        $message = '<script>alert("Data menu berhasil dihapus!"); window.location = "../menu";</script>';
    } else {
        $message = '<script>alert("Data menu gagal dihapus!"); window.location = "../menu";</script>';
    }
} else {
    $message = '<script>alert("Data tidak valid!"); window.location = "../menu";</script>';
}
echo $message;
?>
