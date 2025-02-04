<?php
include "config.php";

// Tangkap input pencarian dari form
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$perPage = 12; // Jumlah produk per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Query untuk menghitung total produk
$countQuery = "SELECT COUNT(*) AS total FROM produk WHERE nama_produk LIKE ? OR kategori_produk LIKE ?";
$countStmt = $koneksi->prepare($countQuery);
$searchTermWithWildcards = "%" . $searchTerm . "%";
$countStmt->bind_param("ss", $searchTermWithWildcards, $searchTermWithWildcards);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $perPage);

// Query untuk menampilkan produk dengan pagination
$sql = "SELECT produk.id_produk, produk.nama_produk, produk.kategori_produk, MIN(produk_gambar.file_path) AS file_path 
        FROM produk 
        LEFT JOIN produk_gambar ON produk.id_produk = produk_gambar.id_produk 
        WHERE produk.nama_produk LIKE ? OR produk.kategori_produk LIKE ? 
        GROUP BY produk.id_produk 
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
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <link rel="icon" href="logowgp.png" /> 
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
<!-- Pagination -->
<div class="mt-8 flex justify-center space-x-2">
            <!-- Tombol Previous -->
            <?php if ($page > 1): ?>
                <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page - 1; ?>" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600 transition duration-300">«</a>
            <?php endif; ?>

            <!-- Nomor Halaman -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>" 
                   class="px-3 py-2 rounded transition duration-300 <?php echo ($i == $page) ? 'bg-teal-700 text-white' : 'bg-gray-200 hover:bg-teal-500 hover:text-white'; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <?php if ($page < $totalPages): ?>
                <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page + 1; ?>" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600 transition duration-300">»</a>
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
