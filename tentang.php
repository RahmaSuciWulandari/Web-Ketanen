<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   UMKM Desa Ketanen
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <header class="bg-teal-700 text-white p-6 shadow-lg">
   <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-3xl font-bold">
     LAPAKKU
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
   </div>
  </header>
  <!-- About Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto text-center">
     <h2 class="text-3xl font-bold text-black-600">
      TENTANG
     </h2>
     <div class="flex flex-col md:flex-row items-center justify-center mt-8 space-y-8 md:space-y-0 md:space-x-8">
      <img alt="Traditional Mentawai house" class="w-full md:w-1/3 rounded-lg shadow-lg" height="300" src="https://storage.googleapis.com/a1aa/image/ruSCtnvaw6ZWPpWdud2PsTBaCrzBBYl2tMXuLAoBMNxxbkfJA.jpg" width="400"/>
      <div class="md:w-1/3">
       <p class="text-lg">
        UMKM Desa Ketanen adalah inisiatif lokal untuk mempromosikan produk-produk unggulan dari desa kami. Kami berkomitmen untuk menyediakan produk berkualitas tinggi yang dibuat dengan cinta dan dedikasi oleh masyarakat setempat.
       </p>
       <p class="text-lg mt-4">
        LAPAKKU merupakan platform yang dirancang untuk memudahkan Anda menemukan informasi lengkap tentang UMKM di Desa Ketanen. Dengan Lapakku, Anda dapat mengeksplorasi kuliner terbaik dan jajanan khas di Desa Ketanen.
       </p>
       <!--
      </div>
      <img alt="Mentawai tribe member" class="w-full md:w-1/3 rounded-lg shadow-lg" height="300" src="https://storage.googleapis.com/a1aa/image/t2ZCtfCbiUxsQqBTrufzoPcPfO3ECQ77fARZ1MXWFZzU8G5PB.jpg" width="400"/>
     </div>
     -->
    </div>
   </section>
   
   <section class="py-16 bg-white">
    <div class="container mx-auto text-center">
     <div class="flex flex-col md:flex-row items-center justify-center mt-8 space-y-8 md:space-y-0 md:space-x-8">
      <!--
      <img alt="Traditional Mentawai house" class="w-full md:w-1/3 rounded-lg shadow-lg" height="300" src="https://storage.googleapis.com/a1aa/image/ruSCtnvaw6ZWPpWdud2PsTBaCrzBBYl2tMXuLAoBMNxxbkfJA.jpg" width="400"/>
      -->
      <div class="md:w-1/3">
       <p class="text-lg">
        UMKM Desa Ketanen adalah inisiatif lokal untuk mempromosikan produk-produk unggulan dari desa kami. Kami berkomitmen untuk menyediakan produk berkualitas tinggi yang dibuat dengan cinta dan dedikasi oleh masyarakat setempat.
       </p>
       <p class="text-lg mt-4">
        LAPAKKU merupakan platform yang dirancang untuk memudahkan Anda menemukan informasi lengkap tentang UMKM di Desa Ketanen. Dengan Lapakku, Anda dapat mengeksplorasi kuliner terbaik dan jajanan khas di Desa Ketanen.
       </p>
      </div>
      <img alt="Mentawai tribe member" class="w-full md:w-1/3 rounded-lg shadow-lg" height="300" src="https://storage.googleapis.com/a1aa/image/t2ZCtfCbiUxsQqBTrufzoPcPfO3ECQ77fARZ1MXWFZzU8G5PB.jpg" width="400"/>
     </div>
    </div>
   </section>

  <footer class="bg-teal-800 text-white py-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
     <div class="text-center md:text-left">
      <h3 class="text-2xl font-bold">
       LAPAKKU
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
      © Copyright 2024 LAPAKKU. All Rights Reserved Design By
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