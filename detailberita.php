<?php
// Include database configuration
include "config.php";

// Tangkap ID berita yang dipilih dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Query untuk menampilkan detail berita berdasarkan ID
    $sql = "SELECT berita.id, berita.judul, berita.isi, berita_gambar.file_path AS gambar, berita.tanggal
            FROM berita
            LEFT JOIN berita_gambar ON berita.id = berita_gambar.id_berita
            WHERE berita.id = ?";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data berita
        $row = $result->fetch_assoc();
    } else {
        // Jika berita tidak ditemukan
        header("Location: berita.php");
        exit();
    }
} else {
    // Jika ID tidak valid, kembali ke halaman berita
    header("Location: berita.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita - Wisata Gunung Pundhut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
    <link rel="icon" href="logowgp.png" />
</head>
<body class="font-roboto bg-gray-100">

    <section class="container mx-auto py-12">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-bold text-teal-700 mb-4"><?php echo htmlspecialchars($row['judul']); ?></h2>
            <p class="text-center text-gray-600 text-sm mb-4"><?php echo date("d M Y", strtotime($row['tanggal'])); ?></p>
            
            <!-- Menampilkan gambar jika ada -->
            <?php
            if (!empty($row['gambar'])) {
                $gambar_url = "uploads/berita/" . $row['gambar'];
            } else {
                $gambar_url = "images/default.jpg";
            }
            ?>
            <img src="<?php echo $gambar_url; ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" class="w-full h-80 object-cover rounded mb-6">
            
            <!-- Isi berita -->
            <p><?php echo nl2br(htmlspecialchars($row['isi'])); ?></p>
        </div>

        <!-- Tombol Kembali ke Halaman Berita -->
        <div class="mt-8 text-center">
            <a href="berita.php" class="bg-teal-500 text-white px-6 py-3 rounded hover:bg-teal-600 transition duration-300">Kembali ke Berita</a>
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

</body>
</html>

<?php
// Close the database connection
$koneksi->close();
?>
