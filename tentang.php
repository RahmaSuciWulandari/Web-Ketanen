<?php
include "config.php";

$data = [
  "total_pengunjung" => 0,
  "total_produk" => 0,
  "total_lapak" => 0
];

// Tambahkan logika untuk menghitung pengunjung
try {
  // Dapatkan alamat IP pengunjung
  $ip_address = $_SERVER['REMOTE_ADDR'];

  // Waktu sekarang
  $current_time = date('Y-m-d H:i:s');

  // Periksa apakah pengunjung ini sudah tercatat
  $sql_check_ip = "SELECT * FROM pengunjung WHERE ip_address = ?";
  $stmt_check_ip = $koneksi->prepare($sql_check_ip);
  $stmt_check_ip->bind_param("s", $ip_address);
  $stmt_check_ip->execute();
  $result_check_ip = $stmt_check_ip->get_result();

  if ($result_check_ip->num_rows > 0) {
      // Jika IP sudah ada, periksa waktu kunjungan terakhir
      $row = $result_check_ip->fetch_assoc();
      $last_visit = strtotime($row['kunjungan_terakhir']);
      $current_time_unix = strtotime($current_time);

      // Batas waktu dalam detik (contoh: 3600 = 1 jam)
      $timeout = 3600;

      if (($current_time_unix - $last_visit) > $timeout) {
          // Perbarui waktu kunjungan terakhir
          $sql_update_time = "UPDATE pengunjung SET kunjungan_terakhir = ? WHERE ip_address = ?";
          $stmt_update_time = $koneksi->prepare($sql_update_time);
          $stmt_update_time->bind_param("ss", $current_time, $ip_address);
          $stmt_update_time->execute();

          // Tambahkan total kunjungan
          $sql_update_total = "UPDATE total_kunjungan SET total = total + 1 WHERE id = 1";
          $koneksi->query($sql_update_total);
      }
  } else {
      // Jika IP belum ada, masukkan data baru
      $sql_insert_ip = "INSERT INTO pengunjung (ip_address, kunjungan_terakhir) VALUES (?, ?)";
      $stmt_insert_ip = $koneksi->prepare($sql_insert_ip);
      $stmt_insert_ip->bind_param("ss", $ip_address, $current_time);
      $stmt_insert_ip->execute();

      // Tambahkan total kunjungan
      $sql_update_total = "UPDATE total_kunjungan SET total = total + 1 WHERE id = 1";
      $koneksi->query($sql_update_total);
  }

  // Ambil total pengunjung
  $sql_total_visits = "SELECT total FROM total_kunjungan WHERE id = 1";
  $result_total_visits = $koneksi->query($sql_total_visits);
  $data['total_pengunjung'] = $result_total_visits->fetch_assoc()['total'];
} catch (Exception $e) {
  echo "Kesalahan: " . $e->getMessage();
}

// Hitung total produk
$sql_produk = "SELECT COUNT(*) as total FROM produk";
$result_produk = $koneksi->query($sql_produk);
$data['total_produk'] = $result_produk->fetch_assoc()['total'];

// Hitung total lapak
$sql_lapak = "SELECT COUNT(*) as total FROM lapak";
$result_lapak = $koneksi->query($sql_lapak);
$data['total_lapak'] = $result_lapak->fetch_assoc()['total'];
?>

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
   <!-- About Us Section -->
   <main class="container mx-auto px-4 py-8">
        <section class="flex flex-col md:flex-row items-center mb-12">
            <div class="md:w-1/2 md:pr-8">
                <h2 class="text-3xl text-teal-700 font-bold mb-4">Tentang WGP</h2>
                <p class="text-gray-700">Wisata Gunung Pundut (WGP) merupakan tempat wisata berupa Dino Park yang populer di Gresik, Jawa Timur. Wisata Gunung Pundut mengusung konsep wisata zaman batu, sehingga wisatawan akan diajak seru-seruan menyusuri gua - yang dulunya bekas tambang kapur. <br/><br/>WGP Dinopark (Wisata Gunung Pundut) adalah destinasi wisata alam yang memadukan keindahan pegunungan dengan tema dinosaurus yang menarik. Terletak di kawasan Gunung Pundut, taman ini menawarkan pengalaman unik bagi pengunjung dari segala usia, terutama keluarga. Dengan replika dinosaurus yang tersebar di berbagai sudut, beberapa di antaranya dapat bergerak dan mengeluarkan suara, pengunjung dapat merasakan sensasi berada di era prasejarah. <br/><br/>Selain itu, WGP Dinopark juga menyediakan zona edukasi yang mengajarkan sejarah dinosaurus dan fosil, serta berbagai aktivitas outdoor seperti arena outbound, tempat camping, dan area bermain anak.<br/><br/></p>
            </div>
            <div class="md:w-1/2">
                <img src="gambar1.jpg" alt="Team photo" class="rounded-lg shadow-lg">
            </div>
        </section>



   <!-- Our Mission -->
   <section class="flex flex-col md:flex-row items-center mb-12">
            <div class="md:w-1/2">
                <img src="gambar2.jpg" alt="Mission" class="rounded-lg shadow-lg">
            </div><br />
            <div class="md:w-1/2 md:pl-8">
                <h2 class="text-3xl text-teal-700 font-bold mb-4">Informasi Umum</h2>
                <div class="flex items-center space-x-4 mb-4">
                  <svg class="h-8 w-8 text-teal-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  <p class="text-gray-700">Alamat: Dsn. Pundut, Ds. Ketanen, Kec. Panceng, Kab. Gresik.</p>
                </div>

                <div class="flex items-center space-x-4 mb-4">
                  <svg class="h-8 w-8 text-teal-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <polyline points="12 6 12 12 16 14" /></svg>
                  <p class="text-gray-700">Jam Operasional: 08.00 - 17.00 setiap hari.</p>
                </div>

                <div class="flex items-center space-x-4 mb-4">
                  <svg class="h-8 w-8 text-teal-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="15" y1="5" x2="15" y2="7" />  <line x1="15" y1="11" x2="15" y2="13" />  <line x1="15" y1="17" x2="15" y2="19" />  <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                  <p class="text-gray-700">Tiket Masuk Rp. 5.000</p>
                </div>

                <div class="flex items-center space-x-4 mb-4">
                <svg class="h-8 w-8 text-teal-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
</svg>
                  <p class="text-gray-700">Kapasitas: ± 2.000 pengunjung.</p>
                </div>
            </div>
        </section>

        <!-- Our Story -->
        <section class="flex flex-col md:flex-row items-center mb-12">
            <div class="md:w-1/2 md:pr-8">
                <h2 class="text-3xl text-teal-700 font-bold mb-4">Sejarah WGP</h2>
                <p class="text-gray-700">WGP Dinopark didirikan tahun 2024 yang memiliki luas area sebesar 5.000 meter persegi, dimana Pemerintah Desa Ketanen Kecamatan Panceng, Gresik mengembangkan lahan bekas tambang batu kapur menjadi wisata alam.<br/><br/></p>
            </div>
            <div class="md:w-1/2">
                <img src="gambar3.jpg" alt="Founders" class="rounded-lg shadow-lg">
            </div>
        </section>

   <section class="text-center mb-12">
    <h2 class="text-2xl text-teal-700 font-bold mb-8">
     Lainnya
    </h2>
    <div class="grid md:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Ikon Globe diganti dengan ikon pengunjung -->
        <i class="fas fa-users mx-auto mb-4 text-4xl text-blue-500"></i>
        <h3 class="text-xl font-bold mb-2">
            <?php echo $data['total_pengunjung']."+ Pengunjung"; ?>
        </h3>
        <a class="text-orange-600 hover:underline" href="index.php">
            Learn more
        </a>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Ikon People diganti dengan ikon lapak -->
        <i class="fas fa-store mx-auto mb-4 text-4xl text-green-500"></i>
        <h3 class="text-xl font-bold mb-2">
            <?php echo $data['total_lapak']."+ Lapak"; ?>
        </h3>
        <a class="text-orange-600 hover:underline" href="lapak.php">
            Learn more
        </a>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Ikon Network diganti dengan ikon produk -->
        <i class="fas fa-box mx-auto mb-4 text-4xl text-red-500"></i>
        <h3 class="text-xl font-bold mb-2">
            <?php echo $data['total_produk']."+ Produk"; ?>
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
 </body>
</html>
