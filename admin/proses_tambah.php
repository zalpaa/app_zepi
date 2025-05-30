<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])) {
    header("location:login.php?pesan=logindulu");
    exit;
}

$id_kategori   = $_POST['id_kategori'];
$nama          = $_POST['nama'];
$deskripsi     = $_POST['deskripsi'];
$harga         = $_POST['harga'];
$ukuran        = $_POST['ukuran'];
$ketersediaan  = $_POST['ketersediaan'];

$ukuran_valid = ['M', 'L', 'XL'];
if (!in_array($ukuran, $ukuran_valid)) {
    die("Ukuran tidak valid!");
}

$target_dir = "../uploads/";
$foto_name = basename($_FILES["foto"]["name"]);
$target_file = $target_dir . $foto_name;
$upload_ok = 1;
$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validasi jenis file gambar
$check = getimagesize($_FILES["foto"]["tmp_name"]);
if ($check === false) {
    die("File bukan gambar!");
}

// Cek ekstensi file yang diizinkan
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($image_file_type, $allowed_types)) {
    die("Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
}

// Coba upload file
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
    $query = "INSERT INTO produk (id_kategori, nama, foto, deskripsi, harga, ukuran, ketersediaan)
              VALUES ('$id_kategori', '$nama', '$foto_name', '$deskripsi', '$harga', '$ukuran', '$ketersediaan')";

    if (mysqli_query($koneksi, $query)) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
} else {
    echo "Gagal mengupload gambar.";
}
?>
