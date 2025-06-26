<?php
session_start();
include "koneksi.php";

$id_users = $_SESSION['id_users'] ?? 1;

$sql = "SELECT k.*, p.nama, p.harga, p.foto FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk
        WHERE k.id_users='$id_users'";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<?php include('header.php'); ?>

<div class="mx-auto pt-20 flex justify-center">
    <div class="w-full max-w-5xl bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Keranjang Belanja</h2>
        <form method="POST" action="checkout_pilih.php" onsubmit="return validateCheckout()">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="border px-4 py-2">Pilih</th>
                            <th class="border px-4 py-2">Produk</th>
                            <th class="border px-4 py-2">Foto</th>
                            <th class="border px-4 py-2">Ukuran</th>
                            <th class="border px-4 py-2">Jumlah</th>
                            <th class="border px-4 py-2">Harga Satuan</th>
                            <th class="border px-4 py-2">Subtotal</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row = mysqli_fetch_assoc($result)) :
                            $subtotal = $row['harga'] * $row['jumlah_produk'];
                        ?>
                        <tr class="text-center hover:bg-green-50 transition duration-150">
                            <td class="border px-4 py-2">
                                <input type="checkbox" name="checkout_item[]" value="<?= $row['id_keranjang'] ?>" class="item-checkbox accent-green-500" data-subtotal="<?= $subtotal ?>">
                            </td>
                            <td class="border px-4 py-2 font-medium text-gray-800"><?= $row['nama'] ?></td>
                            <td class="border px-4 py-2">
                                <img src="../uploads/<?= $row['foto'] ?>" alt="<?= $row['nama'] ?>" class="w-16 h-16 object-cover mx-auto rounded">
                            </td>
                            <td class="border px-4 py-2"><?= $row['ukuran'] ?></td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" onclick="updateJumlah(<?= $row['id_keranjang'] ?>, 'kurang')" class="bg-gray-300 px-2 rounded">-</button>
                                    <span id="jumlah-<?= $row['id_keranjang'] ?>"><?= $row['jumlah_produk'] ?></span>
                                    <button type="button" onclick="updateJumlah(<?= $row['id_keranjang'] ?>, 'tambah')" class="bg-gray-300 px-2 rounded">+</button>
                                </div>
                            </td>
                            <td class="border px-4 py-2">Rp <?= number_format($row['harga']) ?></td>
                            <td class="border px-4 py-2" id="subtotal-<?= $row['id_keranjang'] ?>">Rp <?= number_format($subtotal) ?></td>
                            <td class="border px-4 py-2">
                                <a href="hapus_keranjang.php?id=<?= $row['id_keranjang'] ?>" class="text-red-500 hover:underline">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <p class="text-right text-lg font-semibold text-gray-700 mt-4">Total: Rp <span id="total-harga">0</span></p>

            <!-- Checkout Form -->
            <div class="mt-10 bg-gray-50 p-6 rounded-md shadow-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Informasi Pembeli</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Nama Lengkap:</label>
                        <input type="text" name="nama_lengkap" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">No. HP:</label>
                        <input type="text" name="no_hp" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1 text-gray-700 font-medium">Alamat Lengkap:</label>
                        <textarea name="alamat" required rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1 text-gray-700 font-medium">Catatan Tambahan (opsional):</label>
                        <textarea name="catatan" rows="2" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1 text-gray-700 font-medium">Pilih Kurir:</label>
                        <select name="id_jasa_kurir" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">-- Pilih Kurir --</option>
                            <option value="1">JNE</option>
                            <option value="2">J&T</option>
                            <option value="3">Sicepat</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-green-500 hover:bg-green-600 text-white py-3 rounded-md text-lg font-semibold transition duration-200">
                    Checkout Produk Terpilih
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateJumlah(id_keranjang, aksi) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_jumlah.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            fetch('get_keranjang_item.php?id_keranjang=' + id_keranjang)
            .then(res => res.json())
            .then(data => {
                document.getElementById('jumlah-' + id_keranjang).innerText = data.jumlah_produk;
                document.getElementById('subtotal-' + id_keranjang).innerText = 'Rp ' + number_format(data.subtotal);
                const checkbox = document.querySelector('input[value="'+id_keranjang+'"]');
                if (checkbox) {
                    checkbox.setAttribute('data-subtotal', data.subtotal);
                }
                updateTotal();
            });
        }
    };
    xhr.send("id_keranjang=" + id_keranjang + "&aksi=" + aksi);
}

function number_format(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
        total += parseInt(cb.getAttribute('data-subtotal'));
    });
    document.getElementById('total-harga').innerText = number_format(total);
}

document.querySelectorAll('.item-checkbox').forEach(cb => {
    cb.addEventListener('change', updateTotal);
});

function validateCheckout() {
    const checked = document.querySelectorAll('.item-checkbox:checked');
    if (checked.length === 0) {
        alert('Pilih minimal satu produk untuk checkout.');
        return false;
    }
    return true;
}
</script>

</body>
</html>
