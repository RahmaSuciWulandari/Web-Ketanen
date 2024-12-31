<?php
include "config.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Ambil data lapak
$sql = "SELECT * FROM lapak";
$result = $koneksi->query($sql);

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

//pagging
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$sql = "SELECT * FROM lapak LIMIT $start, $limit";
$result = $koneksi->query($sql);

$total = $koneksi->query("SELECT COUNT(*) as count FROM lapak")->fetch_assoc()['count'];
$pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lapak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
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
  <a href="admintentang.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-newspaper mr-3"></i>
    <span>Tentang</span>
  </a>
</nav>

    </div>
    <div class="absolute bottom-0 w-full p-6">
     <a class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md mt-2" href="#">
      <i class="fas fa-sign-out-alt mr-3">
      </i>
      <form action="" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
     </a>
     <p class="text-gray-400 text-sm mt-6">
      © KKNUQDesaKetanen
     </p>
    </div>
   </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Daftar Lapak</h1>
                <a href="tambah_lapak.php" class="bg-teal-500 text-white px-4 py-2 rounded-md">+ Tambah Lapak</a>
            </div>

            <!-- Table -->
            <div class="bg-white shadow-md rounded-md overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Gambar</th>
                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Nama Lapak</th>
                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Alamat</th>
                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Produk</th>
                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50">
                    <!-- Gambar -->
                    <td class="py-2 px-4 border-b">
                        <img src="<?php echo $row['gambar']; ?>" alt="Gambar Lapak" class="w-16 h-16 rounded-md object-cover">
                    </td>
                    <!-- Nama Lapak -->
                    <td class="py-2 px-4 border-b font-medium text-gray-800"><?php echo $row['nama_lapak']; ?></td>
                    <!-- Alamat -->
                    <td class="py-2 px-4 border-b text-gray-600"><?php echo $row['alamat']; ?></td>
                    <!-- Produk -->
                    <td class="py-2 px-4 border-b text-teal-500">
                        <a href="produk_lapak.php?id=<?php echo $row['id']; ?>" class="hover:underline">Cek Produk</a>
                    </td>
                    <!-- Action -->
                    <td class="py-2 px-4 border-b">
                        <div class="flex space-x-2">
                            <!-- Edit -->
                            <a href="edit_lapak.php?id=<?php echo $row['id']; ?>" class="text-yellow-500 hover:text-yellow-600">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <!-- Hapus -->
                            <form action="hapus_lapak.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="mt-4">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

</div>

            </div>
        </div>
    </div>
    <scripset
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