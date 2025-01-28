<?php
include "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses Logout
    if (isset($_POST['logout'])) {
        $_SESSION['message'] = "Anda telah logout, Silahkan login terlebih dahulu";
        session_unset();
        session_destroy();
        header('location: index.php');
        exit();
    }

    // Proses Simpan Data
    if (isset($_POST['simpan'])) {
        $nama_wisata = trim($_POST['nama_wisata']);
        $lokasi = trim($_POST['lokasi']);
        $tentang_wisata = trim($_POST['tentang_wisata']);
        $gambar = $_FILES['gambar'];

        // Validasi input
        if (empty($nama_wisata) || empty($lokasi) || empty($tentang_wisata)) {
            echo "<script>alert('Semua kolom wajib diisi!'); history.back();</script>";
            exit();
        }

        // Direktori unggah
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Buat folder jika belum ada
        }

        // Proses file gambar
        $file_name = basename($gambar['name']);
        $upload_file = $upload_dir . $file_name;
        $image_file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        // Validasi tipe file
        if (!in_array($image_file_type, $allowed_types)) {
            echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan!'); history.back();</script>";
            exit();
        }

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($gambar['tmp_name'], $upload_file)) {
            echo "<script>alert('Gagal mengunggah file!'); history.back();</script>";
            exit();
        }

        // Simpan data ke database
        $sql = "INSERT INTO wisata (nama_wisata, lokasi, tentang_wisata, gambar) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssss", $nama_wisata, $lokasi, $tentang_wisata, $file_name);

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location.href = 'adminlapak.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "'); history.back();</script>";
        }
    }
}

// Cek login
if (!isset($_SESSION["username"])) {
    $_SESSION['message'] = "Anda telah logout, Silahkan login terlebih dahulu";
    header('location: index.php');
    exit();
}
?>



<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Account Settings
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 </head>
 <body class="bg-gray-100">
 <div class="flex h-screen">
        <!-- Sidebar -->
   <div class="w-64 bg-white shadow-md">
    <div class="p-6">
     <h1 class="text-2xl font-bold text-teal-600 mb-6">WGP</h1>
     <nav class="space-y-2">
  <a href="admin2.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-tachometer-alt mr-3"></i>
    <span>Dashboard</span>
  </a>
  <a href="adminlapak.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-map-marker-alt mr-3"></i>
    <span>Lapak</span>
  </a>
  <a href="admintentang.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-newspaper mr-3"></i>
    <span>Tentang</span>
  </a>
</nav>

    </div>
    <div class="absolute bottom-0 w-full p-6">

     <a class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md mt-2" href="#">
      <i class="fas fa-sign-out-alt mr-3">
      </i>
      <form action="" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
     </a>
     <p class="text-gray-400 text-sm mt-6">
      © KKNUQDesaKetanen
     </p>
    </div>
   </div>
    <!-- Main Content -->
    <div class="flex-1 p-6">
     <div class="bg-white p-6 rounded-lg shadow-md">
     <div class="flex justify-end">
        <button class="bg-teal-500 text-white px-4 py-2 rounded-md" type="submit">
         Simpan
        </button>
       </div>
     <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
     <div id="drop-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center w-full">
    <div class="text-center mb-4">
        <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
        <p class="text-gray-500" id="file-label">+ Tambahkan Gambar dengan Klik atau seret di sini</p>
    </div>
    <input type="file" id="gambar" name="gambar[]" class="hidden" accept="image/*" multiple />
    <div id="preview-area" class="grid grid-cols-3 gap-4 mt-4">
        <!-- Preview gambar akan muncul di sini -->
    </div>
</div>
      <form>
       <div class="mb-4">
        <label class="block text-gray-700 mb-2">
         Nama Wisata
        </label>
        <input class="w-full p-2 border border-gray-300 rounded" type="text" />
       </div>
       <div class="mb-4">
        <label class="block text-gray-700 mb-2">
         Lokasi
        </label>
        <input class="w-full p-2 border border-gray-300 rounded" type="text" />
       </div>
       <div class="mb-4">
        <label class="block text-gray-700 mb-2">
         Tentang Wisata
        </label>
        <textarea class="w-full p-2 border border-gray-300 rounded" rows="4"></textarea>
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll("nav a");

    // Function to handle active link
    const setActiveLink = (link) => {
      navLinks.forEach((nav) => nav.classList.remove("bg-blue-100", "text-gray-900"));
      link.classList.add("bg-blue-100", "text-gray-900");
    };

    // Attach event listener to all nav links
    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        setActiveLink(link); // Set active class
      });
    });

    // Set active link based on the current URL
    const currentPath = window.location.pathname.split("/").pop();
    navLinks.forEach((link) => {
      if (link.getAttribute("href").endsWith(currentPath)) {
        setActiveLink(link);
      }
    });
  });

  //gambar
  document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById("gambar");
        const dropArea = document.getElementById("drop-area");
        const fileLabel = document.getElementById("file-label");
        const previewArea = document.getElementById("preview-area");

        // Fungsi untuk membuat elemen pratinjau gambar
        const createPreview = (file) => {
            const reader = new FileReader();
            reader.onload = (event) => {
                const img = document.createElement("img");
                img.src = event.target.result;
                img.alt = file.name;
                img.classList.add("w-24", "h-24", "object-cover", "rounded-md", "shadow-md");
                previewArea.appendChild(img);
            };
            reader.readAsDataURL(file);
        };

        // Ketika pengguna memilih file melalui input
        fileInput.addEventListener("change", function() {
            previewArea.innerHTML = ""; // Hapus pratinjau sebelumnya
            Array.from(fileInput.files).forEach(createPreview); // Buat pratinjau untuk setiap file
        });

        // Drag-and-drop handling
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
            fileInput.files = files; // Tetapkan file yang di-drop ke input
            previewArea.innerHTML = ""; // Hapus pratinjau sebelumnya
            Array.from(files).forEach(createPreview); // Buat pratinjau untuk setiap file
        });

        // Ketika area di-klik, buka dialog file
        dropArea.addEventListener("click", function() {
            fileInput.click();
        });

        
    });
</script>
 </body>
</html>