<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];
$id_produk = $_GET['id_produk'];
$ukuran = $_GET['ukuran'] ?? '';
$jumlah_produk = $_GET['jumlah'] ?? 1;

// Cek produk
$produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'"));
if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan.'); window.history.back();</script>";
    exit;
}

// Proses saat submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_produk = $_POST['jumlah_produk'];
    $ukuran = $_POST['ukuran'];
    $catatan = $_POST['catatan'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $id_jasa_kurir = $_POST['id_jasa_kurir'];

    $tanggal_pemesanan = date("Y-m-d H:i:s");
    $diskon = 0;
    $harga = $produk['harga'];
    $total_harga = $harga * $jumlah_produk;
    $total_bayar = $total_harga - $diskon;

    $sql = "INSERT INTO pemesanan (id_users, id_produk, id_keranjang, tanggal_pemesanan, jumlah_produk, total_harga, diskon, total_bayar, ukuran, catatan, status, id_jasa_kurir, nama_lengkap, alamat, no_hp) 
            VALUES ('$id_users', '$id_produk', 0, '$tanggal_pemesanan', '$jumlah_produk', '$total_harga', '$diskon', '$total_bayar', '$ukuran', '$catatan', 'pending', '$id_jasa_kurir', '$nama_lengkap', '$alamat', '$no_hp')";

    if (mysqli_query($koneksi, $sql)) {
        $id_pemesanan = mysqli_insert_id($koneksi);
        echo "<script>alert('Pesanan berhasil!'); window.location.href='pembayaran.php?id_pemesanan=$id_pemesanan';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<?php include "header.php"; ?>

<div class="pt-24 flex justify-center">
    <div class="w-full max-w-2xl bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Checkout Produk</h1>

        <div class="mb-6 border p-4 rounded bg-gray-50">
            <p><strong>Nama Produk:</strong> <?= $produk['nama'] ?></p>
            <p><strong>Harga:</strong> Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
        </div>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="harga" value="<?= $produk['harga'] ?>">

            <div>
                <label class="block font-semibold text-gray-700">Jumlah:</label>
                <input type="number" name="jumlah_produk" min="1" value="<?= htmlspecialchars($jumlah_produk) ?>" required class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Ukuran:</label>
                <select name="ukuran" required class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="">-- Pilih Ukuran --</option>
                    <?php
                    $ukuran_options = ['M', 'L', 'XL', 'XXL'];
                    foreach ($ukuran_options as $u) {
                        $selected = ($ukuran == $u) ? 'selected' : '';
                        echo "<option value='$u' $selected>$u</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Catatan:</label>
                <textarea name="catatan" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" required class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Alamat Lengkap:</label>
                <textarea name="alamat" required class="w-full px-3 py-2 border border-gray-300 rounded"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">No. HP:</label>
                <input type="text" name="no_hp" required class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Pilih Kurir:</label>
                <select name="id_jasa_kurir" required class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="">-- Pilih Kurir --</option>
                    <option value="1">JNE</option>
                    <option value="2">J&T</option>
                    <option value="3">Sicepat</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded font-semibold text-lg">
                Proses Checkout
            </button>
        </form>
    </div>
</div>

</body>
</html>
