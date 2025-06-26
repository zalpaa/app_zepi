<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";

$id_users = $_SESSION['id_users'] ?? 0;
$total_keranjang = 0;

if ($id_users) {
    $query_keranjang = mysqli_query($koneksi, "SELECT SUM(jumlah_produk) AS total FROM keranjang WHERE id_users='$id_users'");
    $data = mysqli_fetch_assoc($query_keranjang);
    $total_keranjang = $data['total'] ?? 0;
}
?>
