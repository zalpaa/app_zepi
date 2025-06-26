<?php
include "koneksi.php";

$id_keranjang = $_GET['id_keranjang'];

$sql = "SELECT k.*, p.harga FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk 
        WHERE k.id_keranjang = '$id_keranjang'";
$query = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($query);

$subtotal = $row['harga'] * $row['jumlah_produk'];

// Ambil total semua barang
session_start();
$id_users = $_SESSION['id_users'];
$sqlTotal = "SELECT k.*, p.harga FROM keranjang k 
             JOIN produk p ON k.id_produk = p.id_produk 
             WHERE k.id_users = '$id_users'";
$queryTotal = mysqli_query($koneksi, $sqlTotal);
$total = 0;
while($r = mysqli_fetch_assoc($queryTotal)){
    $total += $r['harga'] * $r['jumlah_produk'];
}

echo json_encode([
    'jumlah_produk' => $row['jumlah_produk'],
    'subtotal' => $subtotal,
    'total' => $total
]);
?>
