<?php
include "config.php";

// Periksa apakah parameter 'id_produk' ada dalam URL
if (isset($_GET['id_produk'])) {
    $id_produk = intval($_GET['id_produk']); // Sanitasi input

    // Query SQL untuk mengambil data produk dan informasi lapak
    $sql = "SELECT produk.nama_produk, produk.deskripsi, produk_gambar.file_path, lapak.alamat, lapak.id_lapak, lapak.kontak
            FROM produk 
            LEFT JOIN produk_gambar ON produk.id_produk = produk_gambar.id_produk 
            LEFT JOIN lapak ON produk.id_lapak = lapak.id_lapak
            WHERE produk.id_produk = ?";
    
    // Menyiapkan query
    $stmt = $koneksi->prepare($sql);

    // Cek jika query gagal disiapkan
    if ($stmt === false) {
        die('Error preparing query: ' . $koneksi->error);
    }

    // Mengikat parameter
    $stmt->bind_param("i", $id_produk);

    // Menjalankan query
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $produk = $result->fetch_assoc(); // Ambil data produk
    } else {
        die("Produk tidak ditemukan.");
    }
} else {
    die("ID Produk tidak ditemukan.");
}

// Query untuk mengambil keunggulan produk
$sql_produk = "SELECT keunggulan FROM produk WHERE id_produk = ?";
$stmt_produk = $koneksi->prepare($sql_produk);
$stmt_produk->bind_param("i", $id_produk);
$stmt_produk->execute();
$result_produk = $stmt_produk->get_result();

// Ambil hasil query
$row_produk = $result_produk->fetch_assoc();
$keunggulan_produk = json_decode($row_produk['keunggulan'], true); // Decode JSON ke array

// Peta ikon untuk setiap keunggulan
$icon_map = [
    "Sertifikasi Halal" => "images/halal.png",
    "Great Quality" => "images/higenis.png",
    "Best Seller" => "images/bs.png",
    "Affordable Price" => "images/murah.png"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo htmlspecialchars($produk['nama_produk']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Title Section -->
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4"> <?php echo htmlspecialchars($produk['nama_produk']); ?></h1>
        <p class="text-gray-500 mb-6"><?php echo htmlspecialchars($produk['alamat']); ?>
            <a class="text-blue-500 font-semibold hover:underline" href="isilapak.php?id_lapak=<?php echo $produk['id_lapak']; ?>">Lihat Lapak</a>
        </p>
        <!-- Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Information Section -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tentang Produk</h2>
                <p class="text-gray-600 leading-relaxed mb-4"> <?php echo htmlspecialchars($produk['deskripsi']); ?></p>
            </div>
            <!-- Image Section -->
            <div class="grid grid-cols-1 gap-4">
                <img src="<?php echo htmlspecialchars($produk['file_path'] ?: 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>" class="rounded-lg w-full h-64 object-cover shadow-md" />
            </div>
        </div>
        <!-- Facilities Section -->
        <div class="mt-12">
    <?php if (!empty($keunggulan_produk)): ?>
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Keunggulan Produk</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php foreach ($keunggulan_produk as $keunggulan): ?>
                <div class="flex flex-col items-center bg-gray-50 shadow-md rounded-lg p-4">
                    <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mb-4">
                        <?php
                            // Validasi apakah ikon ada di folder dan tampilkan fallback jika tidak ada
                            $icon_path = isset($icon_map[$keunggulan]) && file_exists($icon_map[$keunggulan]) ? $icon_map[$keunggulan] : 'images/default.png';
                        ?>
                        <img src="<?php echo $icon_path; ?>" alt="<?php echo htmlspecialchars($keunggulan); ?>" class="w-12 h-12 object-contain" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700"><?php echo htmlspecialchars($keunggulan); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<div>
<a href="https://wa.me/<?php echo htmlspecialchars($produk['kontak']); ?>?text=Halo,%20saya%20ingin%20memesan Produk UMKM Desa Ketanen <sebutkan produk>" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium shadow-md inline-block mt-4">Beli Produk</a>
</div>

    </div>
</body>
</html>
