<?php
include "koneksi.php";

$id_keranjang = $_POST['id_keranjang'];
$aksi = $_POST['aksi'];

if ($aksi === 'tambah') {
    $sql = "UPDATE keranjang SET jumlah_produk = jumlah_produk + 1 WHERE id_keranjang = $id_keranjang";
} else if ($aksi === 'kurang') {
    $sql = "UPDATE keranjang SET jumlah_produk = GREATEST(jumlah_produk - 1, 1) WHERE id_keranjang = $id_keranjang";
}

mysqli_query($koneksi, $sql);
echo "ok"; // output agar AJAX tau berhasil
?>
