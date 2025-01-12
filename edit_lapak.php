<?php
include "config.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Cek apakah ID lapak diberikan
if (!isset($_GET['id'])) {
    header("Location: adminlapak.php");
    exit();
}

$id = $_GET['id'];

// Ambil data lapak berdasarkan ID
$sql = "SELECT * FROM lapak WHERE id_lapak = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: adminlapak.php");
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lapak = $_POST['nama_lapak'];
    $alamat = $_POST['alamat'];

    $update_sql = "UPDATE lapak SET nama_lapak = ?, alamat = ? WHERE id_lapak = ?";
    $update_stmt = $koneksi->prepare($update_sql);
    $update_stmt->bind_param("ssi", $nama_lapak, $alamat, $id);

    if ($update_stmt->execute()) {
        header("Location: adminlapak.php");
        exit();
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lapak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-4">Edit Lapak</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="nama_lapak" class="block text-sm font-medium text-gray-700">Nama Lapak</label>
                <input type="text" name="nama_lapak" id="nama_lapak" value="<?php echo $data['nama_lapak']; ?>" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"><?php echo $data['alamat']; ?></textarea>
            </div>
            <div class="flex justify-end space-x-4">
                <a href="adminlapak.php" class="px-4 py-2 bg-gray-300 rounded-md">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
