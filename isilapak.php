<?php
include "config.php";

// Periksa apakah parameter 'id_lapak' ada dalam URL
if (isset($_GET['id_lapak'])) {
    $id_lapak = intval($_GET['id_lapak']); // Sanitasi input

    // Query SQL untuk mengambil data lapak
    $sql = "SELECT lapak.nama_lapak, lapak.alamat, lapak.kontak, lapak.deskripsi, lapak_gambar.file_pathg
            FROM lapak
            LEFT JOIN lapak_gambar ON lapak.id_lapak = lapak_gambar.id_lapak
            WHERE lapak.id_lapak = ?";
    $stmt = $koneksi->prepare($sql);

    // Cek jika query gagal disiapkan
    if ($stmt === false) {
        die('Error preparing query: ' . $koneksi->error);
    }

    // Mengikat parameter
    $stmt->bind_param("i", $id_lapak);

    // Menjalankan query
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data lapak ditemukan
    if ($result->num_rows > 0) {
        $lapak_data = $result->fetch_assoc(); // Ambil data lapak
    } else {
        die("Lapak tidak ditemukan.");
    }

    // Query untuk mendapatkan produk terkait lapak
    $sql_produk = "SELECT produk.id_produk, produk.nama_produk, produk.kategori_produk, produk.deskripsi, produk_gambar.file_path
                   FROM produk
                   LEFT JOIN produk_gambar ON produk.id_produk = produk_gambar.id_produk
                   WHERE produk.id_lapak = ?";
    $stmt_produk = $koneksi->prepare($sql_produk);
    $stmt_produk->bind_param("i", $id_lapak);
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
        <?php
        if ($result_produk->num_rows > 0) {
            while ($row = $result_produk->fetch_assoc()) {
                $gambar = $row['file_path'] ?: 'default.jpg'; // Gunakan gambar default jika file_path NULL
                echo '<a href="isiproduk.php?id_produk=' . $row['id_produk'] . '" class="block bg-white p-4 rounded-lg text-center shadow-md hover:shadow-lg transition duration-300">';
                echo '<div class="rounded overflow-hidden mb-4">';
                echo '<img src="' . htmlspecialchars($gambar) . '" alt="' . htmlspecialchars($row['nama_produk']) . '" class="w-full h-56 object-cover">';
                echo '</div>';
                echo '<h3 class="text-lg font-bold">' . htmlspecialchars($row['nama_produk']) . '</h3>';
                echo '<p class="text-gray-600">' . htmlspecialchars($row['kategori_produk']) . '</p>';
                echo '</a>';
            }
        } else {
            echo "<p class='text-gray-700'>Tidak ada produk yang ditemukan.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
