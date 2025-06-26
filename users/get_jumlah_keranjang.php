<?php
session_start();
include "koneksi.php";

header('Content-Type: application/json');

$id_users = $_SESSION['id_users'] ?? 0;

if (!$id_users) {
    echo json_encode(['total' => 0]);
    exit;
}

$query = mysqli_query($koneksi, "SELECT SUM(jumlah_produk) AS total FROM keranjang WHERE id_users='$id_users'");
$data = mysqli_fetch_assoc($query);
$total = $data['total'] ?? 0;

echo json_encode(['total' => $total]);
?>
