<?php
include "config.php";
session_start();

$id = $_GET['id'];
$sql = "SELECT * FROM lapak WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$lapak = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lapak = $_POST['nama_lapak'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE lapak SET nama_lapak = ?, alamat = ? WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ssi", $nama_lapak, $alamat, $id);

    if ($stmt->execute()) {
        header("Location: adminlapak.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Lapak</title>
</head>
<body>
    <form method="post">
        <label>Nama Lapak</label>
        <input type="text" name="nama_lapak" value="<?php echo $lapak['nama_lapak']; ?>" required>
        <label>Alamat</label>
        <input type="text" name="alamat" value="<?php echo $lapak['alamat']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
