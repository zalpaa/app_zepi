
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    
    <?php
    session_start();
    include "./koneksi.php";

    if(!isset($_SESSION['id'])) {
    header("location:login.php?pesan=logindulu");
    exit;
}

    // Ambil data kategori dari tabel kategori
    $sql = "SELECT id_kategori, nama FROM kategori";
    $result = $koneksi->query($sql);
    ?>

    <h1>Tambah Produk</h1>
    <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
        <label>Id Kategori</label>
        <select name="id_kategori">
              <option value="">-- Pilih Kategori --</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_kategori'] . "'>" . $row['nama'] . "</option>";
                }
            } else {
                echo "<option value=''>Kategori tidak tersedia</option>";
            }
            ?>
        </select><br><br>

        <label>Nama</label>
        <input type="text" name="nama" required><br><br>

        <label>Foto</label>
        <input type="file" name="foto" accept="image/*" required><br><br>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required></textarea><br><br>

        <label>Harga</label>
        <input type="number" name="harga" step="0.01" required><br><br>

        <label>Ukuran</label>
        <select name="ukuran" >
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select><br><br>

        <label>Ketersediaan</label>
        <select name="ketersediaan" required>
            <option value="ya">Tersedia</option>
            <option value="tidak">Habis</option>
        </select><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>