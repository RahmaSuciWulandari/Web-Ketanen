<?php
include "config.php";

// Periksa apakah parameter 'id_lapak' ada dalam URL
if (isset($_GET['id_lapak'])) {
    $id_lapak = intval($_GET['id_lapak']); // Sanitasi input
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Query untuk mendapatkan informasi lapak
    $sql = "SELECT nama_lapak, alamat, kontak, deskripsi, file_pathg FROM lapak LEFT JOIN lapak_gambar ON lapak.id_lapak = lapak_gambar.id_lapak WHERE lapak.id_lapak = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_lapak);
    $stmt->execute();
    $result = $stmt->get_result();
    $lapak_data = $result->fetch_assoc() ?: die("Lapak tidak ditemukan.");

    // Setup Pagination
    $perPage = 12; // Jumlah produk per halaman
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $perPage;

    // Query untuk menghitung total produk dalam lapak
    $countQuery = "SELECT COUNT(*) AS total FROM produk WHERE id_lapak = ? AND (nama_produk LIKE ? OR kategori_produk LIKE ?)";
    $countStmt = $koneksi->prepare($countQuery);
    $searchTermWithWildcards = "%" . $searchTerm . "%";
    $countStmt->bind_param("iss", $id_lapak, $searchTermWithWildcards, $searchTermWithWildcards);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalRows = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $perPage);

    // Query produk dengan paginasi
    $sql_produk = "SELECT produk.id_produk, produk.nama_produk, produk.kategori_produk, MIN(produk_gambar.file_path) AS file_path 
                    FROM produk 
                    LEFT JOIN produk_gambar ON produk.id_produk = produk_gambar.id_produk 
                    WHERE produk.id_lapak = ? AND (produk.nama_produk LIKE ? OR produk.kategori_produk LIKE ?)
                    GROUP BY produk.id_produk 
                    LIMIT ? OFFSET ?";
    $stmt_produk = $koneksi->prepare($sql_produk);
    $stmt_produk->bind_param("issii", $id_lapak, $searchTermWithWildcards, $searchTermWithWildcards, $perPage, $offset);
    $stmt_produk->execute();
    $result_produk = $stmt_produk->get_result();
} else {
    die("ID Lapak tidak ditemukan.");
}
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo htmlspecialchars($lapak_data['nama_lapak']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 p-4">
    <div class="max-w-8xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Back Button and Divider -->
        <div class="flex items-center mb-6">
            <!--<i class="fas fa-arrow-left text-xl text-gray-600 mr-4 cursor-pointer"></i>-->
            <div class="border-t-2 border-gray-300 flex-grow"></div>
        </div>
        <!-- Title Section -->
        <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold text-teal-800"><?php echo htmlspecialchars($lapak_data['nama_lapak']); ?></h1>
        <p class="text-xl text-gray-700 mb-6"><?php echo htmlspecialchars($lapak_data['alamat']); ?></p>
        </div>
        <!-- Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Informasi Lapak -->
    <div>
        <h2 class="text-2xl font-bold mb-4 text-black-700">Informasi Lapak</h2>
        <p class="text-gray-700 leading-relaxed"><?php echo htmlspecialchars($lapak_data['deskripsi']); ?></p>
    </div>
    <!-- Gambar Lapak -->
    <div class="flex justify-center">
        <div class="rounded-lg overflow-hidden shadow-lg max-w-md">
            <img src="<?php echo htmlspecialchars($lapak_data['file_pathg'] ?: 'default.jpg'); ?>" 
                 alt="Gambar Lapak <?php echo htmlspecialchars($lapak_data['nama_lapak']); ?>" 
                 class="w-full h-80 object-cover">
        </div>
    </div>
</div>

<!-- Produk Section -->
<div class="mt-10">
    <h2 class="text-2xl font-bold mb-6 text-black-700">Produk Lapak</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php while ($row = $result_produk->fetch_assoc()): ?>
                    <a href="isiproduk.php?id_produk=<?php echo $row['id_produk']; ?>" class="block bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <img src="<?php echo htmlspecialchars($row['file_path'] ?: 'default.jpg'); ?>" class="w-full h-56 object-cover mb-4 rounded">
                        <h3 class="text-lg font-bold"> <?php echo htmlspecialchars($row['nama_produk']); ?> </h3>
                        <p class="text-gray-600"> <?php echo htmlspecialchars($row['kategori_produk']); ?> </p>
                    </a>
                <?php endwhile; ?>
            </div>
            <div class="mt-8 flex justify-center space-x-2">
                <?php if ($page > 1): ?>
                    <a href="?id_lapak=<?php echo $id_lapak; ?>&search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page - 1; ?>" class="bg-teal-500 text-white px-3 py-2 rounded">«</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?id_lapak=<?php echo $id_lapak; ?>&search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>" class="px-3 py-2 rounded <?php echo ($i == $page) ? 'bg-teal-700 text-white' : 'bg-gray-200'; ?>"> <?php echo $i; ?> </a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?id_lapak=<?php echo $id_lapak; ?>&search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page + 1; ?>" class="bg-teal-500 text-white px-3 py-2 rounded">»</a>
                <?php endif; ?>
            </div>
</div>

</body>
</html>
