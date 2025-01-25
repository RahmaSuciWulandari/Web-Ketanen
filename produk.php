<?php
include "config.php";

// Tangkap input pencarian dari form
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk menampilkan produk
$sql = "SELECT produk.id_produk, produk.nama_produk, produk.kategori_produk, MIN(produk_gambar.file_path) AS file_path 
        FROM produk 
        LEFT JOIN produk_gambar ON produk.id_produk = produk_gambar.id_produk 
        WHERE produk.nama_produk LIKE ? OR produk.kategori_produk LIKE ? 
        GROUP BY produk.id_produk 
        LIMIT 6"; // Menampilkan lebih banyak produk hasil pencarian

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
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <header class="bg-teal-700 text-white p-2 shadow-lg">
   <div class="container mx-auto flex justify-between items-center">
   <div class="flex items-center space-x-1">
   <img src="logowgp.png" alt="Logo WGPedia" class="h-16 w-auto"/> 
   <h1 class="text-3xl font-bold">
   <a href="index.php">WGP</a>
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
      <button id="menu-button" class="text-white focus:outline-none mt-2 mr-6">
       <i class="fas fa-bars">
       </i>
      </button>
     </div>
    </nav>
   </div>
   <div id="mobile-menu" class="hidden md:hidden">
    <ul class="flex flex-col space-y-4 mt-4 mb-4">
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
   <section class="py-12 bg-gray-50">
    <div class="container mx-auto text-center">
      <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold text-teal-800">ANEKA UMKM KHAS</h1>
        <p class="text-xl text-gray-700 mb-6">Desa Ketanen, Kecamatan Panceng</p>
        <!-- Form Pencarian -->
<div class="flex justify-center mb-8">
    <form action="produk.php" method="GET" class="flex">
        <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Cari..." class="border-2 border-teal-500 px-4 py-2 rounded-l-lg" />
        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-r-lg">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>


    <!-- Menampilkan Produk -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
<?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gambar = $row['file_path'] ?: 'default.jpg'; // Gunakan gambar default jika file_path NULL
            echo '<a href="isiproduk.php?id_produk=' . $row['id_produk'] . '" class="block bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300">';
            echo '<img src="' . $gambar . '" alt="' . htmlspecialchars($row['nama_produk']) . '" class="w-full h-48 object-cover mb-4 rounded">';
            echo '<h3 class="text-lg font-bold">' . htmlspecialchars($row['nama_produk']) . '</h3>';
            echo '<p class="text-gray-600">' . htmlspecialchars($row['kategori_produk']) . '</p>';
            echo '</a>';
        }
    } else {
        echo "<p>Tidak ada produk yang ditemukan.</p>";
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
$koneksi->close();
?>
