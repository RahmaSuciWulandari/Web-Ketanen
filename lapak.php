<?php
// Include the database configuration file
include "config.php";

// Query to fetch lapak data from the database
$sql = "SELECT * FROM lapak"; // Replace 'lapak' with the actual table name in your database
$result = $koneksi->query($sql);
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   UMKM Desa Ketanen
  </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <header class="bg-teal-700 text-white p-2 shadow-lg">
   <div class="container mx-auto flex justify-between items-center">
     <div class="flex items-center space-x-4">
       <img src="logowgp.png" alt="Logo WGPedia" class="h-16 w-auto"/>
       <h1 class="text-3xl font-bold">WGP</h1>
     </div>
     <nav>
       <ul class="hidden md:flex space-x-6">
        <li><a class="hover:underline" href="index.php">Home</a></li>
        <li><a class="hover:underline" href="produk.php">Produk</a></li>
        <li><a class="hover:underline" href="tentang.php">Tentang</a></li>
        <li><a class="hover:underline" href="lapak.php">Lapak</a></li>
        <li><a href="login.php" class="bg-white text-teal-700 px-4 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">Login</a></li>
       </ul>
     </nav>
   </div>
  </header>
  
  <section class="py-12 bg-gray-50">
    <div class="container mx-auto text-center">
      <h1 class="text-4xl font-bold text-teal-800">LAPAK UMKM KHAS</h1>
      <p class="text-xl text-gray-700 mb-6">Desa Ketanen, Kecamatan Panceng</p>
      
      <div class="flex justify-center mb-8">
        <input type="text" placeholder="Cari..." class="border-2 border-teal-500 px-4 py-2 rounded-l-lg" />
        <button class="bg-teal-500 text-white px-4 py-2 rounded-r-lg">
          <i class="fas fa-search"></i>
        </button>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php
        // Check if any data exists in the result
        if ($result->num_rows > 0) {
            // Loop through and display each lapak
            while ($row = $result->fetch_assoc()) {
                echo '<a href="isilapak.php?id=' . $row['id_lapak'] . '" class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">';
                echo '<img class="w-full h-48 object-cover rounded-t-lg" height="200" src="' . $row['gambar'] . '" width="300"/>';
                echo '<h3 class="text-2xl font-bold mt-4">' . $row['nama_lapak'] . '</h3>';
                echo '<p class="text-gray-700 mt-2">' . $row['deskripsi'] . '</p>';
                echo '</a>';
            }
        } else {
            echo '<p class="text-gray-700">Tidak ada lapak yang ditemukan.</p>';
        }
        ?>
      </div>
    </div>
  </section>

  <footer class="bg-teal-800 text-white py-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
      <div class="text-center md:text-left">
        <h3 class="text-2xl font-bold">LAPAKKU</h3>
        <div class="flex space-x-4 mt-4">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="text-center md:text-left mt-8 md:mt-0">
        <h4 class="font-bold">SITEMAP</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="#">HOME</a></li>
          <li><a href="#">PRODUK</a></li>
          <li><a href="#">TENTANG KAMI</a></li>
        </ul>
      </div>
      <div class="text-center md:text-left mt-8 md:mt-0">
        <h4 class="font-bold">QUICK LINKS</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="#">Tentang</a></li>
          <li><a href="#">Artikel</a></li>
          <li><a href="#">Blog</a></li>
        </ul>
      </div>
      <div class="text-center md:text-left mt-8 md:mt-0">
        <h4 class="font-bold">Let's Talk</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="tel:+628234567890">(+62) 82 3456 7890</a></li>
          <li><a href="mailto:info@umkmketanen.com">info@umkmketanen.com</a></li>
          <li>Desa Ketanen, Kecamatan Panceng, Kabupaten Gresik</li>
        </ul>
      </div>
    </div>
    <div class="text-center mt-8">
      <p>© Copyright 2024 LAPAKKU. All Rights Reserved Design By <a class="text-teal-300" href="#">KKNUQDesaKetanen</a></p>
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

<?php
// Close the database connection
$koneksi->close();
?>
