<?php
include "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lapak = trim($_POST['nama_lapak']);
    $alamat = trim($_POST['alamat']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = $_FILES['gambar'];

    if (empty($nama_lapak) || empty($alamat) || empty($deskripsi) || empty($gambar)) {
        echo "<script>alert('Semua kolom wajib diisi!'); history.back();</script>";
        exit();
    }

    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $uploaded_files = [];
    foreach ($gambar['name'] as $index => $file_name) {
        $file_tmp = $gambar['tmp_name'][$index];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_path = $upload_dir . basename($file_name);

        // Validate file type
        if (!in_array($file_type, ["jpg", "jpeg", "png", "gif"])) {
            echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan!'); history.back();</script>";
            exit();
        }

        // Move file
        if (move_uploaded_file($file_tmp, $file_path)) {
            $uploaded_files[] = basename($file_name);
        } else {
            echo "<script>alert('Gagal mengunggah file!'); history.back();</script>";
            exit();
        }
    }

    // Convert uploaded file names to JSON for database storage
    $uploaded_files_json = json_encode($uploaded_files);

    $sql = "INSERT INTO lapak (nama_lapak, alamat, deskripsi, gambar) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ssss", $nama_lapak, $alamat, $deskripsi, $uploaded_files_json);

    if ($stmt->execute()) {
        header("Location: adminlapak.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>



<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Tambah Lapak
  </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <script>
   document.addEventListener("DOMContentLoaded", function() {
    const fileInput = document.getElementById("gambar");
    const dropArea = document.getElementById("drop-area");
    const fileLabel = document.getElementById("file-label");
    const previewArea = document.getElementById("preview-area");

    // When the user clicks the drop area, open the file dialog
    dropArea.addEventListener("click", function() {
        fileInput.click();
    });

    // Handle file drop
    dropArea.addEventListener("dragover", function(event) {
        event.preventDefault();
        dropArea.classList.add("border-blue-400", "bg-blue-100");
    });

    dropArea.addEventListener("dragleave", function() {
        dropArea.classList.remove("border-blue-400", "bg-blue-100");
    });

    dropArea.addEventListener("drop", function(event) {
        event.preventDefault();
        dropArea.classList.remove("border-blue-400", "bg-blue-100");

        const files = event.dataTransfer.files;
        handleFiles(files);
    });

    // Update preview when files are selected
    fileInput.addEventListener("change", function() {
        const files = fileInput.files;
        handleFiles(files);
    });

    // Handle multiple files and preview
    function handleFiles(files) {
        previewArea.innerHTML = ""; // Clear previous previews
        Array.from(files).forEach(file => {
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement("img");
                    img.src = event.target.result;
                    img.alt = file.name;
                    img.classList.add("w-24", "h-24", "object-cover", "rounded", "shadow");
                    previewArea.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
        fileLabel.textContent = files.length > 1 ? `${files.length} files selected` : files[0].name;
    }
});
  </script>
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
        <a class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md mt-2" href="#">
          <i class="fas fa-sign-out-alt mr-3"></i>
          <form action="" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
        </a>
        <p class="text-gray-400 text-sm mt-6">© KKNUQDesaKetanen</p>
      </div>
    </div>
    <!-- Main Content -->
    <div class="flex-1 p-6">
      <form action="tambah_lapak.php" method="POST" enctype="multipart/form-data">
      
        <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Tambah Lapak</h1>
                <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
          <div class="grid grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Lapak</label>
              <input class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Nama Lapak" type="text" name="nama_lapak" required />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
              <input class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Lokasi" type="text" name="alamat" required />
            </div>
            <div class="col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
              <textarea class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tuliskan Deskripsi Lapak" rows="4" name="deskripsi" required></textarea>
            </div>
            
            <div class="col-span-2">
  <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
  <div id="drop-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center w-full">
    <div class="text-center">
      <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
      <p class="text-gray-500" id="file-label">+ Tambahkan Gambar dengan Klik atau seret disini</p>
    </div>
    <input type="file" id="gambar" name="gambar[]" class="hidden" accept="image/*" multiple required/>
    <div id="preview-area" class="mt-4 flex flex-wrap gap-4"></div>
  </div>
</div>
<div class="col-span-2">
<div class="flex justify-between items-center mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                <a href="tambah_produk.php" class="bg-teal-500 text-white px-4 py-2 rounded-md">Klik untuk menambahkan Produk</a>
            </div>
            </div>
            
          </div>
        </div>
      </form>
      
    </div>
  </div>
 </body>
</html>
