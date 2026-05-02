<?php
include("connect.php");
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : '';
$nama_menu = (isset($_POST['nama_menu'])) ? htmlentities($_POST['nama_menu']) : '';
$keterangan = (isset($_POST['keterangan'])) ? htmlentities($_POST['keterangan']) : '';
$kat_menu = (isset($_POST['kat_menu'])) ? htmlentities($_POST['kat_menu']) : '';
$harga = (isset($_POST['harga'])) ? htmlentities($_POST['harga']) : '';
$stok = (isset($_POST['stok'])) ? htmlentities($_POST['stok']) : '';

$kode_rand = rand(10000, 99999);
$target_dir = "../assets/img/" . $kode_rand . "_";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!empty($_POST['input_menu_validate'])) {
    //cek apakah gambar atau bukan
    $cek = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($cek === false) {
        $message = '<script>alert("File yang diupload bukan gambar!");</script>';
        $statusUpload = 0;
    } else {
        $statusUpload = 1;
        if (file_exists($target_file)) {
            $message = '<script>alert("File sudah ada!")</script>';
            $statusUpload = 0;
        } else {
            //cek ukuran file
            if ($_FILES["foto"]["size"] > 5000000) {
                $message = '<script>alert("Ukuran file terlalu besar!");</script>';
                $statusUpload = 0;
            } else {
                //cek format file
                if ($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg") {
                    $message = '<script>alert("Format file tidak sesuai!");</script>';
                    $statusUpload = 0;
                } else {
                    if ($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg' && $imageType != 'gif') {
                        $message = '<script>alert("Format file tidak sesuai!");</script>';
                        $statusUpload = 0;
                    }
                }
            }
        }
    }
    if ($statusUpload == 0) {
        $message .= '<script>alert("File gagal diupload!"); window.location = "../menu";</script>';
    } else {
        $select = mysqli_query($conn, "SELECT * FROM tb_daftar_menu WHERE nama_menu='$nama_menu'");
        if (mysqli_num_rows($select) > 0) {
            $message = '<script>alert("Nama menu sudah digunakan!"); window.location = "../menu";</script>';
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $query = mysqli_query($conn, "UPDATE tb_daftar_menu SET foto='" . $kode_rand . "_" . $_FILES['foto']['name'] . "', nama_menu='$nama_menu', keterangan='$keterangan', kategori='$kat_menu', harga='$harga', stok='$stok' WHERE id=$id");
                if ($query) {
                    $message = '<script>alert("Data menu berhasil diperbarui!"); window.location = "../menu";</script>';
                } else {
                    $message = '<script>alert("Data menu gagal diperbarui!"); window.location = "../menu";</script>';
                }
            } else {
                $message = '<script>alert("maaf, terjadi kesalahan saat mengupload file."); window.location = "../menu";</script>';
            }
        }
    }
}
echo $message;
?>