<?php
include("connect.php");
$message = '';
$kode_order = (isset($_POST['kode_order'])) ? htmlentities($_POST['kode_order']) : '';
$meja = (isset($_POST['meja'])) ? htmlentities($_POST['meja']) : '';
$pelanggan = (isset($_POST['pelanggan'])) ? htmlentities($_POST['pelanggan']) : '';
$total = (isset($_POST['total'])) ? htmlentities($_POST['total']) : '';
$uang = (isset($_POST['uang'])) ? htmlentities($_POST['uang']) : '';
$kembalian = $uang - $total;

if (!empty($_POST['bayar_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_bayar WHERE id_bayar='$kode_order'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Order ini sudah dibayar!"); window.location = "../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
    } elseif ($kembalian < 0) {
        $message = '<script>alert("Uang yang diberikan kurang!"); window.location = "../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_bayar (id_bayar,nominal_uang,total_bayar) VALUES ('$kode_order', '$uang', '$total')");
        if ($query) {
            $message = '<script>alert("Pembayaran berhasil! \nKembalian: Rp' . number_format($kembalian, 0, ',', '.') . '"); window.location = "../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        } else {
            $message = '<script>alert("Pembayaran gagal!"); window.location = "../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        }
    }
}
echo $message;
?>