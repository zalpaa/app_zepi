<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])) {
    header("location:login.php?pesan=logindulu");
    exit;
}

// Tangkap semua data dari form
$id_produk     = $_POST['id_produk'];
$id_kategori   = $_POST['id_kategori'];
$nama          = mysqli_real_escape_string($koneksi, $_POST['nama']);
$deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$harga         = $_POST['harga'];
$ukuran        = $_POST['ukuran'];
$stok           =$_POST['stok'];

// Ambil data produk lama (untuk ambil nama file foto lama jika tidak diupdate)
$query_lama = mysqli_query($koneksi, "SELECT foto FROM produk WHERE id_produk = '$id_produk'");
$data_lama = mysqli_fetch_assoc($query_lama);
$foto_lama = $data_lama['foto'];

// Cek apakah ada file foto baru yang diunggah
if (!empty($_FILES['foto']['name'])) {
    $target_dir = "../uploads/";
    $nama_file_baru = time() . '_' . basename($_FILES["foto"]["name"]);
    $target_file = $target_dir . $nama_file_baru;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Validasi file gambar
    if (!in_array($imageFileType, $valid_extensions)) {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        exit;
    }

    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        // Hapus file lama jika ada
        if (file_exists("../uploads/" . $foto_lama) && $foto_lama != '') {
            unlink("../uploads/" . $foto_lama);
        }
        $nama_foto_final = $nama_file_baru;
    } else {
        echo "Gagal mengupload gambar.";
        exit;
    }
} else {
    // Tidak ada upload baru, gunakan foto lama
    $nama_foto_final = $foto_lama;
}

// Update data ke database
$sql_update = "UPDATE produk SET 
    id_kategori = '$id_kategori',
    nama = '$nama',
    foto = '$nama_foto_final',
    deskripsi = '$deskripsi',
    harga = '$harga',
    ukuran = '$ukuran',
    stok = '$stok'
    WHERE id_produk = '$id_produk'";

if (mysqli_query($koneksi, $sql_update)) {
    echo "<script>alert('Produk berhasil diperbarui!'); window.location.href = 'dashboard.php';</script>";
} else {
    echo "Gagal mengupdate produk: " . mysqli_error($koneksi);
}
?>
