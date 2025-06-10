<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body>
  <header class="bg-white fixed w-full shadow-md">
    <div class="container mx-auto px-4 py-4 relative flex items-center">
      <!-- Kiri (Logo) -->
      <h1 class="text-2xl font-bold text-gray-800">FLAZ</h1>

      <!-- Tengah (Menu) -->
      <nav class="absolute left-1/2 transform -translate-x-1/2">
        <ul class="flex space-x-6">
          <li><a href="./home.php" class="text-gray-600 hover:text-gray-900">Home</a></li>
          <li><a href="./produk.php" class="text-gray-600 hover:text-gray-900">Produk</a></li>
          <li><a href="./about.php" class="text-gray-600 hover:text-gray-900">Tentang Kami</a></li>
          <li><a href="./kontak.php" class="text-gray-600 hover:text-gray-900">Kontak</a></li>
          <li><a href="./riwayat_pesanan.php" class="text-gray-600 hover:text-gray-900">Riwayat Pesanan</a></li>
        </ul>
      </nav>

      <!-- Kanan (Ikon) -->
      <div class="ml-auto flex space-x-4">
        <a href="user.php"><i class="fa-solid fa-user text-gray-600 hover:text-gray-900"></i></a>
        <a href="keranjang.php"><i class="fa-solid fa-cart-shopping text-gray-600 hover:text-gray-900"></i></a>
      </div>
    </div>
  </header>
</body>
</html>