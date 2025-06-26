<?php
session_start();
include "koneksi.php";

$id_produk = $_GET['id_produk'];
$sql = "SELECT * FROM produk WHERE id_produk = $id_produk";
$query = mysqli_query($koneksi, $sql);
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

$ukuran_options = ['M', 'L', 'XL', 'XXL'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<?php include "header.php"; ?>

<div class="pt-24"></div>
<div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow-md flex flex-col md:flex-row gap-8">
    <!-- Gambar Produk -->
    <div class="w-full md:w-1/2">
        <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>" class="rounded-lg shadow">
    </div>

    <!-- Info Produk -->
    <div class="w-full md:w-1/2">
        <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= $produk['nama'] ?></h1>
        <p class="text-gray-600 mb-4"><?= $produk['deskripsi'] ?></p>
        <p class="text-2xl font-bold text-green-600 mb-4">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

        <form class="space-y-4">
            <div>
                <label for="ukuranSelect" class="block text-gray-700 font-semibold">Pilih Ukuran</label>
                <select id="ukuranSelect" class="w-full border border-gray-300 rounded px-3 py-2">
                    <?php foreach ($ukuran_options as $ukuran): ?>
                        <option value="<?= $ukuran ?>"><?= $ukuran ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="jumlahInput" class="block text-gray-700 font-semibold">Jumlah</label>
                <input type="number" id="jumlahInput" min="1" value="1" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <p class="text-sm text-gray-500">Stok tersedia: <?= $produk['stok'] ?></p>

            <div class="flex gap-4 mt-6">
                <button type="button" id="keranjangBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                    Masukkan ke Keranjang
                </button>
                <a href="#" id="beliBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow text-center">
                    Beli Sekarang
                </a>
            </div>
            <div id="notif" class="text-green-600 text-sm mt-2"></div>
        </form>

        <a href="javascript:history.back()" class="text-blue-500 text-sm mt-4 inline-block hover:underline">← Kembali</a>
    </div>
</div>

<script>
document.getElementById('keranjangBtn').addEventListener('click', function () {
    const id_produk = <?= $produk['id_produk'] ?>;
    const ukuran = document.getElementById('ukuranSelect').value;
    const jumlah = document.getElementById('jumlahInput').value;

    const formData = new FormData();
    formData.append('id_produk', id_produk);
    formData.append('ukuran', ukuran);
    formData.append('jumlah', jumlah);

    fetch('tambah_keranjang_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('notif').innerText = data.pesan;

        fetch('get_jumlah_keranjang.php')
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('keranjang-badge');
            if (badge) {
                badge.innerText = data.total;
                badge.style.display = (data.total > 0) ? 'inline' : 'none';
            }
        });
    });
});

document.getElementById('beliBtn').addEventListener('click', function (e) {
    e.preventDefault();
    const ukuran = document.getElementById('ukuranSelect').value;
    const jumlah = document.getElementById('jumlahInput').value;
    const id_produk = <?= $produk['id_produk'] ?>;
    window.location.href = `checkout.php?id_produk=${id_produk}&ukuran=${ukuran}&jumlah=${jumlah}`;
});
</script>

</body>
</html>
