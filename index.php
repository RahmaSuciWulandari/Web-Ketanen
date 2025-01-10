<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Wisata Gunung Pundhut(WGP)
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <!-- <link rel="stylesheet" href="style.css" type="text/css">-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/> 
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <header class="bg-teal-700 text-white p-6 shadow-lg">
   <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-3xl font-bold">
     WGPedia
    </h1>
    <nav>
     <ul class="hidden md:flex space-x-6">
      <li>
       <a class="hover:underline" href="index.php">
        Home
       </a>
      </li>
      <li>
       <a class="hover:underline" href="produk.php">
        Produk
       </a>
      </li>
      <li>
       <a class="hover:underline" href="tentang.php">
        Tentang
       </a>
      </li>
      <li>
       <a class="hover:underline" href="lapak.php">
        Lapak
       </a>
      </li>
      <li>
      <a href="login.php" class="bg-white text-teal-700 px-4 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">
       Login
      </a>
      </li>
     </ul>
     <div class="md:hidden">
      <button id="menu-button" class="text-white focus:outline-none">
       <i class="fas fa-bars">
       </i>
      </button>
     </div>
    </nav>
   </div>
   <div id="mobile-menu" class="hidden md:hidden">
    <ul class="flex flex-col space-y-4 mt-4">
     <li>
      <a class="hover:underline" href="index.php">
       Home
      </a>
     </li>
     <li>
      <a class="hover:underline" href="produk.php">
       Produk
      </a>
     </li>
     <li>
      <a class="hover:underline" href="tentang.php">
       Tentang Kami
      </a>
     </li>
     <li>
      <a class="hover:underline" href="Lapak.php">
       Lapak
      </a>
     </li>
     <li>
      <a href="login.php" class="bg-white text-teal-700 px-4 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">
       Login
      </a>
      </li>
    </ul>
    
   </div>
  </header>
  <section class="relative">
    <img alt="Surfer riding a wave" class="w-full h-[600px] object-cover" height="800" src="https://asset-2.tstatic.net/surabaya/foto/bank/images/wisata-dino-park-di-Gresik.jpg" width="1920"/>
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white">
    <div class="bg-white bg-opacity-50 p-4 mt-4 rounded fadein">
        <h1 class="text-4xl md:text-6xl font-bold text-teal-800">
            Selamat Datang di Profil Wisata Gunung Pundhut(WGP)
           </h1><br>
           <h2 class="text-black">
            Temukan Informasi wisata dan UMKM khas Desa Ketanen disini. Dari yang unik hingga Epic. All in one in here!!.
           </h2>
    </div>
    <!--<img alt="Gambar pemandangan desa Ketanen dengan produk lokal" class="mx-auto rounded-lg shadow-lg" height="400" src="https://storage.googleapis.com/a1aa/image/l9Ns5otAen0lYibe71ywfioxmfds9WDSpwhOhDKjMbNSkN5PB.jpg" width="100%"/>-->
   </div>
  </section>
  <!-- About Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto text-center">
     <h2 class="text-3xl font-bold text-teal-800">
      TENTANG
     </h2>
     <div class="flex flex-col md:flex-row items-center justify-center mt-8 space-y-8 md:space-y-0 md:space-x-8">
      <img alt="Traditional Mentawai house" class="w-full md:w-1/3 rounded-lg shadow-lg" height="300" src="https://asset-2.tstatic.net/travel/foto/bank/images/Pengunjung-anak-anak-berwisata-di-Wisata-Gunung-Pundut-WGP.jpg" width="400"/>
      <div class="md:w-1/3">
       <p class="text-lg text-black">
       Wisata Gunung Pundut (WGP) merupakan tempat wisata berupa Dino Park yang populer di Gresik, Jawa Timur. Wisata Gunung Pundut mengusung konsep wisata zaman batu, sehingga wisatawan akan diajak seru-seruan menyusuri gua - yang dulunya bekas tambang kapur.
       </p>
       <p class="text-lg mt-4 text-black">
        WGPedia merupakan platform yang dirancang untuk memudahkan Anda menemukan informasi lengkap tentang Wisata dan UMKM di Desa Ketanen. Dengan WGPedia, Anda dapat mengeksplorasi keindahan dan potensi yang ada di Desa Ketanen.
       </p>
       <a href="tentang.php" class="inline-block mt-4 bg-teal-600 text-white px-4 py-2 rounded" href="#">
        Lihat selengkapnya &gt;
       </a>
      </div>
      <img class="w-full md:w-1/3 rounded-lg shadow-lg" height="300" src="https://asset-2.tstatic.net/travel/foto/bank/images/Fasilitas-kolam-renang-yang-tersedia-di-Wisata-Gunung-Pundut-WGP.jpg" width="400"/>
     </div>
    </div>
   </section>
   <section class="py-12 bg-gray-50">
    <div class="container mx-auto text-center">
     <h2 class="text-3xl font-bold mb-6 text-center">
      Produk Kami
     </h2>
     <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
      <a href="isiproduk.php"  class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
       <img alt="Gambar produk 1" class="w-full h-48 object-cover rounded-t-lg" height="200" src="https://storage.googleapis.com/a1aa/image/TYymQVImLS6UE1AgX9xX8LxUFYH5qVlUb1iXen0RLeqBZTenA.jpg" width="300"/>
       <h3 class="text-2xl font-bold mt-4">
        Produk 1
       </h3>
       <p class="text-gray-700 mt-2">
        Deskripsi singkat produk 1.
       </p>
      </a>
      <div class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
       <img alt="Gambar produk 2" class="w-full h-48 object-cover rounded-t-lg" height="200" src="https://storage.googleapis.com/a1aa/image/vLHpXh8UnNJBBNxBEJdJiRongJYx4ydOeKGKReVyHZA9YTenA.jpg" width="300"/>
       <h3 class="text-2xl font-bold mt-4">
        Produk 2
       </h3>
       <p class="text-gray-700 mt-2">
        Deskripsi singkat produk 2.
       </p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
       <img alt="Gambar produk 3" class="w-full h-48 object-cover rounded-t-lg" height="200" src="https://storage.googleapis.com/a1aa/image/EYHeqmZHqpQaCCnBN6G5zherYgZ8DovCv9iHdBoyglU7YTenA.jpg" width="300"/>
       <h3 class="text-2xl font-bold mt-4">
        Produk 3
       </h3>
       <p class="text-gray-700 mt-2">
        Deskripsi singkat produk 3.
       </p>
      </div>
     </div>
     <div class="flex justify-center mt-8">
       <a href="produk.php" class="inline-block bg-teal-600 text-white px-4 py-2 rounded" href="#">
         Lihat selengkapnya &gt;
       </a>
     </div>
    </div>
 </section>
 
  <!--
  <section class="bg-white py-12">
   <div class="container mx-auto text-center">
    <h2 class="text-3xl font-bold mb-6">
     Tentang Kami
    </h2>
    <p class="text-gray-700 mb-10">
     UMKM Desa Ketanen adalah inisiatif lokal untuk mempromosikan produk-produk unggulan dari desa kami. Kami berkomitmen untuk menyediakan produk berkualitas tinggi yang dibuat dengan cinta dan dedikasi oleh masyarakat setempat.
    </p>
    <img alt="Gambar tim UMKM Desa Ketanen" class="mx-auto rounded-lg shadow-lg" height="400" src="https://storage.googleapis.com/a1aa/image/IR4qGJm8aTqKKluLaRBMidKCP0T0phxhmKn2nae6hMXjsJfTA.jpg" width="800"/>
   </div>
  </section>
  
  <section class="py-12 bg-gray-50">
   <div class="container mx-auto text-center">
    <h2 class="text-3xl font-bold mb-6">
     Kontak Kami
    </h2>
    <p class="text-gray-700 mb-10">
     Jika Anda memiliki pertanyaan atau ingin memesan produk, jangan ragu untuk menghubungi kami melalui informasi di bawah ini.
    </p>
    <div class="flex flex-col items-center space-y-6">
     <div class="flex items-center space-x-3">
      <i class="fas fa-phone-alt text-green-700">
      </i>
      <span class="text-gray-700">
       +62 123 456 789
      </span>
     </div>
     <div class="flex items-center space-x-3">
      <i class="fas fa-envelope text-green-700">
      </i>
      <span class="text-gray-700">
       info@umkmketanen.com
      </span>
     </div>
     <div class="flex items-center space-x-3">
      <i class="fas fa-map-marker-alt text-green-700">
      </i>
      <span class="text-gray-700">
       Desa Ketanen, Kecamatan Panceng, Kabupaten Gresik
      </span>
     </div>
    </div>
   </div>
  </section>
  -->
  <footer class="bg-teal-800 text-white py-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
     <div class="text-center md:text-left">
      <h3 class="text-2xl font-bold">
       WGPedia
      </h3>
      <div class="flex space-x-4 mt-4">
       <a href="#">
        <i class="fab fa-facebook-f">
        </i>
       </a>
       <a href="#">
        <i class="fab fa-twitter">
        </i>
       </a>
       <a href="#">
        <i class="fab fa-instagram">
        </i>
       </a>
       <a href="#">
        <i class="fab fa-linkedin-in">
        </i>
       </a>
      </div>
     </div>
     <div class="text-center md:text-left mt-8 md:mt-0">
      <h4 class="font-bold">
       SITEMAP
      </h4>
      <ul class="mt-4 space-y-2">
       <li>
        <a href="#">
         HOME
        </a>
       </li>
       <li>
        <a href="#">
         PRODUK
        </a>
       </li>
       <li>
        <a href="#">
         TENTANG KAMI
        </a>
       </li>
      </ul>
     </div>
     <div class="text-center md:text-left mt-8 md:mt-0">
      <h4 class="font-bold">
       QUICK LINKS
      </h4>
      <ul class="mt-4 space-y-2">
       <li>
        <a href="#">
         Tentang
        </a>
       </li>
       <li>
        <a href="#">
         Artikel
        </a>
       </li>
       <li>
        <a href="#">
         Blog
        </a>
       </li>
      </ul>
     </div>
     <div class="text-center md:text-left mt-8 md:mt-0">
      <h4 class="font-bold">
       Let's Talk
      </h4>
      <ul class="mt-4 space-y-2">
       <li>
        <a href="tel:+628234567890">
         (+62) 82 3456 7890
        </a>
       </li>
       <li>
        <a href="mailto:info@umkmketanen.com">
            info@umkmketanen.com
        </a>
       </li>
       <li>
        Desa Ketanen, Kecamatan Panceng, Kabupaten Gresik
       </li>
      </ul>
     </div>
    </div>
    <div class="text-center mt-8">
     <p>
      © Copyright 2024 WGPedia. All Rights Reserved Design By
      <a class="text-teal-300" href="#">
       KKNUQDesaKetanen
      </a>
     </p>
    </div>
  </footer>
  <script>
   document.getElementById('menu-button').addEventListener('click', function() {
     var menu = document.getElementById('mobile-menu');
     if (menu.classList.contains('hidden')) {
       menu.classList.remove('hidden');
     } else {
       menu.classList.add('hidden');
     }
   });
  </script>
 </body>
</html>