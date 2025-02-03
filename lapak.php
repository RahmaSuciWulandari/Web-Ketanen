<?php
// Include database configuration
include "config.php";

// Tangkap input pencarian dari form
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$perPage = 12; // Jumlah lapak per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Query untuk menghitung total lapak
$countQuery = "SELECT COUNT(*) AS total FROM lapak WHERE nama_lapak LIKE ? OR deskripsi LIKE ?";
$countStmt = $koneksi->prepare($countQuery);
$searchTermWithWildcards = "%" . $searchTerm . "%";
$countStmt->bind_param("ss", $searchTermWithWildcards, $searchTermWithWildcards);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $perPage);

// Query untuk menampilkan lapak dengan pagination
$sql = "SELECT lapak.id_lapak, lapak.nama_lapak, lapak.deskripsi, MIN(lapak_gambar.file_pathg) AS file_pathg 
        FROM lapak 
        LEFT JOIN lapak_gambar ON lapak.id_lapak = lapak_gambar.id_lapak 
        WHERE lapak.nama_lapak LIKE ? OR lapak.deskripsi LIKE ? 
        GROUP BY lapak.id_lapak 
        LIMIT ? OFFSET ?";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ssii", $searchTermWithWildcards, $searchTermWithWildcards, $perPage, $offset);
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
 <header class="sticky top-0 bg-teal-700 text-white p-6 shadow-lg z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center">
        <img src="logowgp.png" alt="Logo WGPedia" class="h-12 w-auto"/>
        <h1 class="text-3xl font-bold"><a href="index.php">WGP</a></h1>
      </div>
      <nav class="w-full md:w-auto">
        <!-- Desktop menu -->
        <ul class="hidden md:flex space-x-6">
          <li><a class="hover:underline" href="index.php">Home</a></li>
          <li><a class="hover:underline" href="produk.php">Produk</a></li>
          <li><a class="hover:underline" href="tentang.php">Tentang</a></li>
          <li><a class="hover:underline" href="lapak.php">Lapak</a></li>
          <li><a class="hover:underline" href="berita.php">Berita</a></li>
          <li><a href="login.php" class="bg-white text-teal-700 px-4 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">Login</a></li>
        </ul>
        
        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center absolute right-8 top-9">
          <!-- Ikon hamburger -->
          <button id="menu-button" class="text-white focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </nav>
    </div>

    <!-- Mobile dropdown menu -->
    <div id="mobile-menu" class="hidden md:hidden mt-4">
      <ul class="flex flex-col space-y-4">
        <li><a class="hover:underline" href="index.php">Home</a></li>
        <li><a class="hover:underline" href="produk.php">Produk</a></li>
        <li><a class="hover:underline" href="tentang.php">Tentang</a></li>
        <li><a class="hover:underline" href="lapak.php">Lapak</a></li>
        <li><a class="hover:underline" href="berita.php">Berita</a></li>
        <li><a href="login.php" class="bg-white text-teal-700 px-4 py-2 rounded hover:bg-teal-600 hover:text-white transition duration-300">Login</a></li>
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

<!-- Pagination -->
<div class="mt-8 flex justify-center space-x-2">
        <?php if ($page > 1): ?>
          <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page - 1; ?>" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600">«</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>" 
            class="px-3 py-2 rounded <?php echo ($i == $page) ? 'bg-teal-700 text-white' : 'bg-gray-200 hover:bg-teal-500 hover:text-white'; ?>">
            <?php echo $i; ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page + 1; ?>" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600">»</a>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <footer class="bg-teal-800 text-white py-8">
  <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
    <div class="text-center md:text-left">
      <h3 class="text-2xl font-bold">WGP</h3>
      <div class="flex space-x-4 mt-4">
        <a href="https://wa.me/6282333888807" target="_blank" rel="noopener noreferrer" class="hover:text-teal-400">
          <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://www.instagram.com/wgp_dinopark?igsh=eHhkbXhqZW5kNG13" class="hover:text-teal-400">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.tiktok.com/@wgp.dino.park?_t=ZS-8tGecttmHgI&_r=1" class="hover:text-teal-400">
          <i class="fab fa-tiktok"></i>
        </a>
        <a href="https://www.facebook.com/profile.php?id=61559314482951" class="hover:text-teal-400">
          <i class="fab fa-facebook"></i>
        </a>
      </div>
    </div>
    <div class="text-center md:text-left mt-8 md:mt-0">
      <h4 class="font-bold">SITEMAP</h4>
      <ul class="mt-4 space-y-2">
        <li><a href="index.php" class="hover:text-teal-400">HOME</a></li>
        <li><a href="produk.php" class="hover:text-teal-400">PRODUK</a></li>
        <li><a href="lapak.php" class="hover:text-teal-400">LAPAK</a></li>
        <li><a href="tentang.php" class="hover:text-teal-400">TENTANG KAMI</a></li>
      </ul>
    </div>
    <div class="text-center md:text-left mt-8 md:mt-0">
      <h4 class="font-bold">Let's Talk</h4>
      <ul class="mt-4 space-y-2">
        <li><a href="tel:+6282333888807" class="hover:text-teal-400">(+62) 823-3388-8807</a></li>
        <li>Desa Ketanen, </li>
        <li>Kecamatan Panceng, Kabupaten Gresik</li>
      </ul>
    </div>
  </div>
  <div class="text-center mt-8">
    <p>
      © Copyright 2024 WGP. All Rights Reserved Design By 
      <a class="text-teal-300 hover:text-teal-400" href="https://www.instagram.com/kknuq_ketanen2025?igsh=MXR3OTJrcnlmcnh4bA==">
        KKNUQDesaKetanen
      </a>
    </p>
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
