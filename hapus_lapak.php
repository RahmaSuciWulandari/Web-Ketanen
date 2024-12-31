<?php
include "config.php";
session_start();

// Periksa apakah ID dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Pastikan ID berupa angka untuk keamanan

    // Query untuk menghapus data
    $sql = "DELETE FROM lapak WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman adminlapak.php setelah sukses
        header("Location: adminlapak.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika query gagal
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
