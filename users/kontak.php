<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FLAZ | Kontak</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
 
<!-- Header -->
<?php include "header.php"?>

  <!-- Kontak Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Kontak Kami</h2>
      <div class="max-w-2xl mx-auto">
        <form action="#" method="POST" class="bg-gray-100 p-8 rounded-lg shadow-md">
          <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="nama">Nama</label>
            <input class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" type="text" id="nama" name="nama" placeholder="Nama Anda" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="email">Email</label>
            <input class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" type="email" id="email" name="email" placeholder="Email Anda" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="pesan">Pesan</label>
            <textarea class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" id="pesan" name="pesan" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
          </div>
          <button type="submit" class="w-full bg-pink-500 text-white py-2 rounded-md hover:bg-pink-600">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
<?php include "footer.php" ?>
</body>
</html>
