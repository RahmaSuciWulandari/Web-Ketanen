<?php
include "config.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Ambil ID lapak dari URL
$id_lapak = isset($_GET['id']) ? $_GET['id'] : 0;

// Ambil data lapak
$sql_lapak = "SELECT * FROM lapak WHERE id_lapak = ?";
$stmt = $koneksi->prepare($sql_lapak);
$stmt->bind_param("i", $id_lapak);
$stmt->execute();
$lapak = $stmt->get_result()->fetch_assoc();

if (!$lapak) {
    echo "Lapak tidak ditemukan.";
    exit();
}

// Ambil data produk untuk lapak
$sql_produk = "SELECT * FROM produk WHERE id_lapak = ?";
$stmt = $koneksi->prepare($sql_produk);
$stmt->bind_param("i", $id_lapak);
$stmt->execute();
$result_produk = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Produk - <?php echo $lapak['nama_lapak']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-semibold mb-6">Produk dari Lapak: <?php echo $lapak['nama_lapak']; ?></h1>

                <!-- Tombol Tambah Produk -->
                <div class="mb-4">
                    <a href="tambah_produk.php?id=<?php echo $id_lapak; ?>" class="bg-teal-500 text-white px-4 py-2 rounded-md">+ Tambah Produk</a>
                </div>

                <!-- Table -->
                <div class="bg-white shadow-md rounded-md overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">No.</th>
                                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Nama Produk</th>
                                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Harga</th>
                                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Deskripsi</th>
                                <th class="py-2 px-4 bg-gray-100 text-left text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result_produk->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <!-- Nomor -->
                                    <td class="py-2 px-4 border-b font-medium text-gray-800"><?php echo $no++; ?></td>
                                    <!-- Nama Produk -->
                                    <td class="py-2 px-4 border-b font-medium text-gray-800"><?php echo $row['nama_produk']; ?></td>
                                    <!-- Harga -->
                                    <td class="py-2 px-4 border-b text-gray-600"><?php echo "Rp " . number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <!-- Deskripsi -->
                                    <td class="py-2 px-4 border-b text-gray-600"><?php echo $row['deskripsi']; ?></td>
                                    <!-- Aksi -->
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex space-x-2">
                                            <!-- Edit -->
                                            <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" class="text-yellow-500 hover:text-yellow-600">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <!-- Hapus -->
                                            <form action="hapus_produk.php" method="POST" class="inline">
                                                <input type="hidden" name="id" value="<?php echo $row['id_produk']; ?>">
                                                <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
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
