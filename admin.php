<?php
include "config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$data = [
    "total_pengunjung" => 0,
    "total_produk" => 0,
    "total_lapak" => 0
];

$sql_pengunjung = "SELECT COUNT(*) as total FROM pengunjung";
$result_pengunjung = $koneksi->query($sql_pengunjung);
$data['total_pengunjung'] = $result_pengunjung->fetch_assoc()['total'];

$sql_produk = "SELECT COUNT(*) as total FROM produk";
$result_produk = $koneksi->query($sql_produk);
$data['total_produk'] = $result_produk->fetch_assoc()['total'];

$sql_lapak = "SELECT COUNT(*) as total FROM lapak";
$result_lapak = $koneksi->query($sql_lapak);
$data['total_lapak'] = $result_lapak->fetch_assoc()['total'];

//logout
if (isset($_POST['logout'])) {
    $_SESSION['message'] = "Anda telah logout, Silahkan login terlebih dahulu";
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}

if (!isset($_SESSION["username"])) {
    $_SESSION['message'] = "Anda telah logout, Silahkan login terlebih dahulu";
    header('location: index.php');
    exit();
}
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Dashboard Admin
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 </head>
 <body class="bg-gray-100 font-sans antialiased">
  <div class="flex h-screen">
   <!-- Sidebar -->
   <div class="w-64 bg-white shadow-md">
    <div class="p-6">
     <h1 class="text-2xl font-bold text-teal-600 mb-6">WGPedia</h1>
     <nav class="space-y-2">
  <a href="admin.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-tachometer-alt mr-3"></i>
    <span>Dashboard</span>
  </a>
  <a href="adminlapak.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-map-marker-alt mr-3"></i>
    <span>Lapak</span>
  </a>
  <!-- <a href="admintentang.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-newspaper mr-3"></i>
    <span>Tentang</span>
  </a> -->
</nav>

</div>
    <div class="absolute bottom-0 p-6">
    <div class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md w-58">
    <i class="fas fa-sign-out-alt mr-3"></i>
    <form action="" method="post">
        <input type="submit" name="logout" value="Logout" class="bg-transparent text-gray-600 hover:text-gray-900 cursor-pointer">
    </form>
</div>

     <p class="text-gray-400 text-sm mt-6">
      © KKNUQDesaKetanen
     </p>
    </div>
   </div>
   <!-- Main content -->
   <div class="flex-1 p-6">
    <!-- Top bar -->
    <div class="flex justify-between items-center mb-6">
     <div class="relative w-1/3">
      <!-- <input class="w-full p-2 pl-10 border border-gray-300 rounded-md" placeholder="Cari" type="text"/>
      <i class="fas fa-search absolute left-3 top-3 text-gray-400">
      </i> -->
     </div>
     <div class="flex items-center space-x-4">
      <!-- <i class="fas fa-bell text-gray-600">
      </i> -->
      <div class="flex items-center space-x-2">
       <img alt="User Avatar" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/pzJFINbbZe0eDUTJUI0s18W277p5FUUzVJRFEo42fSesKm9PB.jpg" width="40"/>
       <div>
        <p class="text-gray-900">
         WGPedia
        </p>
        <p class="text-gray-400 text-sm">
         Admin
        </p>
       </div>
      </div>
     </div>
    </div>
    <!-- Dashboard cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
     <div class="bg-white p-6 rounded-lg shadow-md">
      <div class="flex items-center justify-between mb-4">
       <h2 class="text-gray-600">
        Total Pengunjung
       </h2>
       <i class="fas fa-user text-purple-500">
       </i>
      </div>
     <div class="text-3xl font-bold text-gray-900 mb-2">
     <?php echo $data['total_pengunjung']; ?>
      </div>
       <!-- <div class="text-sm text-green-500">
       8.5% Up from yesterday
      </div> -->
     </div>
     <div class="bg-white p-6 rounded-lg shadow-md">
      <div class="flex items-center justify-between mb-4">
       <h2 class="text-gray-600">
        Total Produk
       </h2>
       <i class="fas fa-box text-yellow-500">
       </i>
      </div>
      <div class="text-3xl font-bold text-gray-900 mb-2">
      <?php echo $data['total_produk']; ?>
      </div>
      <!-- <div class="text-sm text-green-500">
       1.3% Up from past week
      </div> -->
     </div>
     <div class="bg-white p-6 rounded-lg shadow-md">
      <div class="flex items-center justify-between mb-4">
       <h2 class="text-gray-600">
        Total Lapak
       </h2>
       <i class="fas fa-chart-line text-green-500">
       </i>
      </div>
      <div class="text-3xl font-bold text-gray-900 mb-2">
      <?php echo $data['total_lapak']; ?>
      </div>
      <!-- <div class="text-sm text-red-500">
       4.3% Down from yesterday
      </div> -->
     </div>
    </div>
   </div>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll("nav a");

    // Function to handle active link
    const setActiveLink = (link) => {
      navLinks.forEach((nav) => nav.classList.remove("bg-blue-100", "text-gray-900"));
      link.classList.add("bg-blue-100", "text-gray-900");
    };

    // Attach event listener to all nav links
    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        setActiveLink(link); // Set active class
      });
    });

    // Set active link based on the current URL
    const currentPath = window.location.pathname.split("/").pop();
    navLinks.forEach((link) => {
      if (link.getAttribute("href").endsWith(currentPath)) {
        setActiveLink(link);
      }
    });
  });
</script>


 </body>
</html>