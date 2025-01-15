<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Tentang
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <header class="bg-teal-700 text-white p-2 shadow-lg">
   <div class="container mx-auto flex justify-between items-center">
   <div class="flex items-center space-x-4">
   <img src="logowgp.png" alt="Logo WGPedia" class="h-16 w-auto"/> 
   <h1 class="text-3xl font-bold">
     WGP
    </h1>
    </div>
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
   <!-- About Us Section -->
   <main class="container mx-auto px-4 py-8">
        <section class="flex flex-col md:flex-row items-center mb-12">
            <div class="md:w-1/2 md:pr-8">
                <h2 class="text-3xl font-bold mb-4">About Us</h2>
                <p class="text-gray-700">Wisata Gunung Pundut (WGP) merupakan tempat wisata berupa Dino Park yang populer di Gresik, Jawa Timur. Wisata Gunung Pundut mengusung konsep wisata zaman batu, sehingga wisatawan akan diajak seru-seruan menyusuri gua - yang dulunya bekas tambang kapur.</p>
            </div>
            <div class="md:w-1/2">
                <img src="https://placehold.co/600x400" alt="Team photo" class="rounded-lg shadow-lg">
            </div>
        </section>



   <!-- Our Mission -->
   <section class="flex flex-col md:flex-row items-center mb-12">
            <div class="md:w-1/2">
                <img src="https://placehold.co/600x400" alt="Mission" class="rounded-lg shadow-lg">
            </div><br />
            <div class="md:w-1/2 md:pl-8">
                <h2 class="text-3xl font-bold mb-4">General Information</h2>
                <p class="text-gray-700">We believe not just in growing bigger, but in growing better. And growing better means aligning the success of your own business with the success of your customers. Win-win!</p>
            </div>
        </section>

        <!-- Our Story -->
        <section class="flex flex-col md:flex-row items-center mb-12">
            <div class="md:w-1/2 md:pr-8">
                <h2 class="text-3xl font-bold mb-4">Our History</h2>
                <p class="text-gray-700">In 2004, fellow MIT graduate students Brian Halligan and Dharmesh Shah noticed a major shift in the way people shop and purchase products. Buyers didn't want to be interrupted by ads; they wanted helpful information.</p>
                <p class="text-gray-700 mt-4">In 2006, they founded HubSpot to help companies use that shift to grow better with inbound marketing.</p>
            </div>
            <div class="md:w-1/2">
                <img src="https://placehold.co/600x400" alt="Founders" class="rounded-lg shadow-lg">
            </div>
        </section>

   <section class="text-center mb-12">
    <h2 class="text-2xl font-bold mb-8">
     Other Information
    </h2>
    <div class="grid md:grid-cols-3 gap-8">
     <div class="bg-white p-6 rounded-lg shadow-lg">
      <img alt="Globe icon" class="mx-auto mb-4 w-16" src="https://placehold.co/100x100"/>
      <h3 class="text-xl font-bold mb-2">
       12,000+ Pengunjung
      </h3>
      <a class="text-orange-600 hover:underline" href="index.php">
       Learn more
      </a>
     </div>
     <div class="bg-white p-6 rounded-lg shadow-lg">
      <img alt="People icon" class="mx-auto mb-4 w-16" src="https://placehold.co/100x100"/>
      <h3 class="text-xl font-bold mb-2">
       7,600+ Lapak
      </h3>
      <a class="text-orange-600 hover:underline" href="lapak.php">
       Learn more
      </a>
     </div>
     <div class="bg-white p-6 rounded-lg shadow-lg">
      <img alt="Network icon" class="mx-auto mb-4 w-16" src="https://placehold.co/100x100"/>
      <h3 class="text-xl font-bold mb-2">
       205,000+ Produk
      </h3>
      <a class="text-orange-600 hover:underline" href="produk.php">
       Learn more
      </a>
     </div>
    </div>
   </section>
   <!-- <section class="text-center">
    <div class="flex justify-center space-x-4 mb-4">
     <img alt="Award badge 1" class="rounded-lg shadow-lg w-20" src="https://placehold.co/100x100"/>
     <img alt="Award badge 2" class="rounded-lg shadow-lg w-20" src="https://placehold.co/100x100"/>
     <img alt="Award badge 3" class="rounded-lg shadow-lg w-20" src="https://placehold.co/100x100"/>
     <img alt="Award badge 4" class="rounded-lg shadow-lg w-20" src="https://placehold.co/100x100"/>
    </div>
    <p class="text-gray-700">
     Voted #1 in 318 categories
    </p>
    <a class="text-orange-600 hover:underline" href="#">
     Learn more
    </a>
   </section> -->
   
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
  </main>
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
 </body>
</html>
