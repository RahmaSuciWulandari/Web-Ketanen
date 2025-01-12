<?php
include "config.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Ambil ID produk dari URL
$id_produk = isset($_GET['id']) ? $_GET['id'] : 0;

// Ambil data produk berdasarkan ID
$sql_produk = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $koneksi->prepare($sql_produk);
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$produk = $stmt->get_result()->fetch_assoc();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $sql_update = "UPDATE produk SET nama_produk = ?, harga = ?, deskripsi = ? WHERE id_produk = ?";
    $stmt = $koneksi->prepare($sql_update);
    $stmt->bind_param("sdsi", $nama_produk, $harga, $deskripsi, $id_produk);

    if ($stmt->execute()) {
        header("Location: cekproduk.php?id=" . $produk['id_lapak']);
        exit();
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-semibold mb-4">Edit Produk</h1>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="nama_produk" value="<?php echo $produk['nama_produk']; ?>" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Harga</label>
                    <input type="number" name="harga" value="<?php echo $produk['harga']; ?>" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full p-2 border rounded-md" required><?php echo $produk['deskripsi']; ?></textarea>
                </div>
                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md">Simpan</button>
                    <a href="cekproduk.php?id=<?php echo $produk['id_lapak']; ?>" class="text-teal-500">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>