<?php
include 'config.php'; // Pastikan koneksi database benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul_berita']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
    
    // Simpan berita terlebih dahulu
    $sql_berita = "INSERT INTO berita (judul, isi) VALUES ('$judul', '$isi')";
    if (mysqli_query($koneksi, $sql_berita)) {
        $id_berita = mysqli_insert_id($koneksi); // Ambil ID berita terbaru

        // Folder penyimpanan gambar
        $upload_dir = "uploads/berita/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!empty($_FILES['gambar']['name'][0])) { // Pastikan ada file
            foreach ($_FILES['gambar']['name'] as $key => $file_name) {
                $file_tmp = $_FILES['gambar']['tmp_name'][$key];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $new_file_name = uniqid('berita_', true) . '.' . $file_ext;
                $target_file = $upload_dir . $new_file_name;

                // Validasi ekstensi file
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                if (in_array($file_ext, $allowed_extensions)) {
                    if (move_uploaded_file($file_tmp, $target_file)) {
                        // Simpan ke tabel berita_gambar
                        $sql_gambar = "INSERT INTO berita_gambar (id_berita, file_path) VALUES ('$id_berita', '$new_file_name')";
                        mysqli_query($koneksi, $sql_gambar);
                    }
                }
            }
        }

        echo "Berita dan gambar berhasil ditambahkan.";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>


<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tambah Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 font-sans">
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
                <a href="admin_berita.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
                    <i class="fas fa-newspaper mr-3"></i>
                    <span>Berita</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <form action="tambah_berita.php" method="POST" enctype="multipart/form-data">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Tambah Berita</h1>
                    <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md">Simpan</button>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Berita</label>
                        <input class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Judul Berita" type="text" name="judul_berita" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita</label>
                        <textarea class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tuliskan Isi Berita" rows="6" name="isi_berita" required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                        <div id="drop-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center w-full">
                            <div class="text-center">
                                <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
                                <p class="text-gray-500" id="file-label">+ Tambahkan Gambar</p>
                            </div>
                            <input type="file" id="gambar" name="gambar[]" class="hidden" accept="image/*" multiple required/>
                            <div id="preview-area" class="mt-4 flex flex-wrap gap-4"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById("gambar");
            const dropArea = document.getElementById("drop-area");
            const fileLabel = document.getElementById("file-label");
            const previewArea = document.getElementById("preview-area");

            dropArea.addEventListener("click", function() {
                fileInput.click();
            });

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

            fileInput.addEventListener("change", function() {
                const files = fileInput.files;
                handleFiles(files);
            });

            function handleFiles(files) {
                previewArea.innerHTML = "";
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
</body>
</html>
