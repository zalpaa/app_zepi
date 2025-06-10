<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="users/style.css">
        <style>

    .footer {
    width: 100%;
    background:black;
    padding: 2rem 5%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 0; /* hapus radius agar rata tepi */
    margin: 0;
}


.footer .box-container {
   max-width: 1000px; /* atau 1200px tetap boleh */
   margin: 0 auto;
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* dari 25rem jadi 200px */
   gap: 1.7rem; /* jarak antar box diperkecil */
}



.footer .box-container .box h3{
   text-transform: uppercase;
   color:white;
   font-size: 19px;
   padding-bottom: 2rem;
}

.footer .box-container .box p,
.footer .box-container .box a{
   display: block;
   font-size: 16px;
   color:white;
   padding:1rem 0;
}



.footer .box-container .box p i,
.footer .box-container .box a i{
   color:white;
   padding-right: .5rem;
}



.footer .box-container .box a:hover{
   color:#FF0000;
   text-decoration: underline;
}

.footer .credit{
   text-align: center;
   font-size: 1rem;
   color:white;
   border-top: var(--border);
   margin-top: 2.5rem;
   padding-top: 2.5rem;
}

.footer .credit span{
   color:white;
}

@media (max-width: 768px) {
    .cont {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .cont {
        grid-template-columns: 1fr;
    }
}

        </style>
</head>
<body>

    <section class="footer" >
   <div class="box-container">

      <div class="box">
         <h3>quick links</h3>
         <a href="home.php">home</a>
         <a href="produk.php">produk</a>
         <a href="tentang kami.php">tentang kami</a>
         <a href="kontak.php">kontak</a>
      </div>

      <div class="box">
         <h3>extra links</h3>
         <a href="login.php">login</a>
         <a href="register.php">register</a>
         <a href="keranjang.php">keranjang</a>
         <a href="riwayat_pesanan.php">riwayat pesanan</a>
      </div>

      <div class="box">
         <h3>contact info</h3>
         <p> 
            <i class="fas fa-phone"></i> 0812345 
         </p> 
         <p> 
            <i class="fas fa-phone"></i> 0854321
         </p>
         <p> flaz@gmail.com </p>
      </div>

      <div class="box">
         <h3>follow us</h3>

         <a href="https://www.instagram.com/zlfanra_?igsh=aTB2aG43M2g4aDdo"> <i class="fab fa-instagram"></i></a>
         <a href="https://www.instagram.com/fauzyyy_144?igsh=MWExNTZnbjMweDcydw=="> <i class="fab fa-instagram"></i></a>
         <a href="https://www.tiktok.com/@rpl1smega?is_from_webapp=1&sender_device=pc"> <i class="fab fa-tiktok"></i></a>
      </div> 

   </div>

   <!-- <p class="credit"> &copy; 2025 FLAZ. All rights reserved.</p> -->
       <p class="credit"> &copy; copyright  @ <?php echo date('Y'); ?> by <span>zalfaradit</span> </p>
</section>
</body>
</html>

