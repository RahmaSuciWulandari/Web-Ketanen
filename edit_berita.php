<?php
include "config.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID berita dari parameter URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data berita dari database
$sql = "SELECT * FROM berita WHERE id = $id";
$result = $koneksi->query($sql);
$berita = $result->fetch_assoc();

if (!$berita) {
    echo "Berita tidak ditemukan.";
    exit();
}

// Ambil gambar terkait dari tabel berita_gambar
$sqlGambar = "SELECT id, file_path FROM berita_gambar WHERE id_berita = $id";
$resultGambar = $koneksi->query($sqlGambar);
$images = [];
while ($row = $resultGambar->fetch_assoc()) {
    $images[] = $row;  // Menyimpan setiap gambar dalam array $images
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    // Update data berita
    $sqlUpdate = "UPDATE berita SET judul = ?, isi = ? WHERE id = ?";
    $stmt = $koneksi->prepare($sqlUpdate);
    $stmt->bind_param("ssi", $judul, $isi, $id);
    $stmt->execute();

    // Hapus gambar yang dipilih
    if (isset($_POST['hapus_gambar'])) {
        foreach ($_POST['hapus_gambar'] as $hapusId) {
            // Ambil file path gambar dari database
            $sqlHapusGambar = "SELECT file_path FROM berita_gambar WHERE id = ?";
            $stmtHapus = $koneksi->prepare($sqlHapusGambar);
            $stmtHapus->bind_param("i", $hapusId);
            $stmtHapus->execute();
            $resultHapus = $stmtHapus->get_result();
            $gambar = $resultHapus->fetch_assoc();

            if ($gambar) {
                $filePath = "uploads/berita/" . $gambar['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath); // Hapus file gambar dari server
                }

                // Hapus data gambar dari database
                $sqlDeleteGambar = "DELETE FROM berita_gambar WHERE id = ?";
                $stmtDeleteGambar = $koneksi->prepare($sqlDeleteGambar);
                $stmtDeleteGambar->bind_param("i", $hapusId);
                $stmtDeleteGambar->execute();
            }
        }
    }

    // Cek jika ada gambar baru yang diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = "uploads/berita/";
        $fileName = basename($_FILES['gambar']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Periksa apakah file adalah gambar
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFilePath)) {
                // Masukkan data gambar ke database
                $sqlInsertGambar = "INSERT INTO berita_gambar (id_berita, file_path) VALUES (?, ?)";
                $stmtGambar = $koneksi->prepare($sqlInsertGambar);
                $stmtGambar->bind_param("is", $id, $fileName);
                $stmtGambar->execute();
            } else {
                echo "Gagal mengunggah gambar.";
            }
        } else {
            echo "Hanya file gambar yang diizinkan (JPG, PNG, JPEG, GIF).";
        }
    }

    // Redirect setelah update
    header("Location: admin_berita.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-semibold mb-6">Edit Berita</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700">Judul</label>
                <input type="text" name="judul" value="<?php echo htmlspecialchars($berita['judul']); ?>" required class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Isi Berita</label>
                <textarea name="isi" required class="w-full px-4 py-2 border rounded-md"><?php echo htmlspecialchars($berita['isi']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Foto Saat Ini</label>
                <div class="grid grid-cols-3 gap-4">
                    <?php foreach ($images as $img): ?>
                        <div>
                            <img src="uploads/berita/<?php echo $img['file_path']; ?>" alt="Gambar" class="w-24 h-24 object-cover rounded-md shadow">
                            <label>
                                <input type="checkbox" name="hapus_gambar[]" value="<?php echo $img['id']; ?>"> Hapus
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Tambah Gambar Baru</label>
                <input type="file" name="gambar" class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="flex justify-end space-x-4">
                <a href="admin_berita.php" class="px-4 py-2 bg-gray-300 rounded-md">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
