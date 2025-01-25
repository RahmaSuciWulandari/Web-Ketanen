<?php
// Include the database configuration file
include "config.php";

// Tangkap input pencarian dari form
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk menampilkan lapak yang sesuai dengan pencarian
$sql = "SELECT lapak.id_lapak, lapak.nama_lapak, lapak.deskripsi, MIN(lapak_gambar.file_pathg) AS file_pathg 
        FROM lapak 
        LEFT JOIN lapak_gambar ON lapak.id_lapak = lapak_gambar.id_lapak
        WHERE lapak.nama_lapak LIKE ? OR lapak.deskripsi LIKE ?
        GROUP BY lapak.id_lapak
        LIMIT 6"; // Menampilkan hasil pencarian terbatas

$stmt = $koneksi->prepare($sql);
$searchTermWithWildcards = "%" . $searchTerm . "%"; // Menambahkan wildcard untuk pencarian
$stmt->bind_param("ss", $searchTermWithWildcards, $searchTermWithWildcards); // Bind parameter

$stmt->execute();
$result = $stmt->get_result();
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <header class="bg-teal-700 text-white p-4 shadow-lg">
   <div class="container mx-auto flex justify-between items-center">
     <div class="flex items-center space-x-2">
       <img src="logowgp.png" alt="Logo WGPedia" class="h-12 w-auto"/>
       <h1 class="text-2xl font-bold">WGP</h1>
     </div>
     <nav>
       <ul class="hidden md:flex space-x-4">
        <li><a class="hover:underline" href="index.php">Home</a></li>
        <li><a class="hover:underline" href="produk.php">Produk</a></li>
        <li><a class="hover:underline" href="tentang.php">Tentang</a></li>
        <li><a class="hover:underline" href="lapak.php">Lapak</a></li>
        <li><a href="login.php" class="bg-white text-teal-700 px-3 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">Login</a></li>
       </ul>
       <button id="menu-button" class="md:hidden text-white  focus:outline-none mr-4 mt-4">
         <i class="fas fa-bars"></i>
       </button>
     </nav>
   </div>
   <div id="mobile-menu" class="hidden md:hidden bg-teal-700">
    <ul class="flex flex-col space-y-4 p-4 mt-4">
     <li><a class="hover:underline text-white" href="index.php">Home</a></li>
     <li><a class="hover:underline text-white" href="produk.php">Produk</a></li>
     <li><a class="hover:underline text-white" href="tentang.php">Tentang</a></li>
     <li><a class="hover:underline text-white" href="lapak.php">Lapak</a></li>
     <li><a href="login.php" class="bg-white text-teal-700 px-3 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">Login</a></li>
    </ul>
   </div>
  </header>
  
  <section class="py-12 bg-gray-50">
    <div class="container mx-auto text-center">
      <h1 class="text-3xl font-bold text-teal-800">LAPAK UMKM KHAS</h1>
      <p class="text-lg text-gray-700 mb-6">Desa Ketanen, Kecamatan Panceng</p>
      
      <!-- Form Pencarian -->
<div class="flex justify-center mb-8">
  <form action="lapak.php" method="GET" class="flex">
    <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Cari..." class="border border-teal-500 px-4 py-2 rounded-l-lg focus:outline-none" />
    <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-r-lg hover:bg-teal-600 transition duration-300">
      <i class="fas fa-search"></i>
    </button>
  </form>
</div>


      <!-- Menampilkan Hasil Pencarian -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $gambar = $row['file_pathg'] ?: 'default.jpg'; // Gunakan gambar default jika file_pathg NULL
              echo '<a href="isilapak.php?id_lapak=' . $row['id_lapak'] . '" class="block bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300">';
              echo '<img src="' . $gambar . '" alt="' . htmlspecialchars($row['nama_lapak']) . '" class="w-full h-48 object-cover mb-4 rounded">';
              echo '<h3 class="text-lg font-bold mb-2">' . htmlspecialchars($row['nama_lapak']) . '</h3>';
              echo '</a>';
          }
      } else {
          echo "<p>Tidak ada lapak yang ditemukan.</p>";
      }
  ?>
</div>

    </div>
  </section>

  <footer class="bg-teal-800 text-white py-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
      <div class="text-center md:text-left">
        <h3 class="text-2xl font-bold">WGP</h3>
        <div class="flex space-x-4 mt-4">
  <a href="#"><i class="fas fa-envelope"></i></a>
  <a href="https://www.instagram.com/wgp_dinopark?igsh=eHhkbXhqZW5kNG13"><i class="fab fa-instagram"></i></a>
  <a href="#"><i class="fab fa-tiktok"></i></a>
  <a href="#"><i class="fab fa-youtube"></i></a>
</div>

      </div>
      <div class="text-center md:text-left mt-8 md:mt-0">
        <h4 class="font-bold">SITEMAP</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="index.php">HOME</a></li>
          <li><a href="produk.php">PRODUK</a></li>
          <li><a href="lapak.php">LAPAK</a></li>
          <li><a href="tentang.php">TENTANG KAMI</a></li>
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
      <p>© Copyright 2024 WGP. All Rights Reserved Design By <a class="text-teal-300" href="https://www.instagram.com/kknuq_ketanen2025?igsh=MXR3OTJrcnlmcnh4bA==">KKNUQDesaKetanen</a></p>
    </div>
  </footer>

  <script>
    document.getElementById('menu-button').addEventListener('click', function() {
      var menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });
  </script>
 </body>
</html>

<?php
// Close the database connection
$koneksi->close();
?>
