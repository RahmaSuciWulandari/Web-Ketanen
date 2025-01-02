<?php
include "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['jumlah_produk'])) {
        $jumlah_produk = intval($_POST['jumlah_produk']);
    } elseif (isset($_POST['submit_produk'])) {
        // Handle the submitted product data
        $id_lapak = trim($_POST['id_lapak']);
        $produk = $_POST['produk'];
        
        foreach ($produk as $item) {
            $nama_produk = $item['nama'];
            $kategori = $item['kategori'];
            $deskripsi = $item['deskripsi'];
            $keunggulan = json_encode($item['keunggulan']);
            $harga = $item['harga'];
            
            // Insert product into database, let the database generate the ID
            $sql = "INSERT INTO produk (id_lapak, nama_produk, kategori, deskripsi, keunggulan, harga) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("ssssss", $id_lapak, $nama_produk, $kategori, $deskripsi, $keunggulan, $harga);

            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
                exit();
            }
        }

        header("Location: adminlapak.php");
        exit();
    }
}
?>

<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Tambah Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <script>
    function generateProductForms() {
        const jumlahProduk = parseInt(document.getElementById('jumlah_produk').value);
        const formContainer = document.getElementById('produk-forms');
        formContainer.innerHTML = ''; // Clear previous forms

        for (let i = 1; i <= jumlahProduk; i++) {
            formContainer.innerHTML += `
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-bold mb-4">Produk ${i}</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" name="produk[${i}][nama]" class="w-full py-2 px-4 border border-gray-300 rounded-lg" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori UMKM</label>
                            <input type="text" name="produk[${i}][kategori]" class="w-full py-2 px-4 border border-gray-300 rounded-lg" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Produk</label>
                            <input type="number" name="produk[${i}][harga]" class="w-full py-2 px-4 border border-gray-300 rounded-lg" required />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                            <textarea name="produk[${i}][deskripsi]" class="w-full py-2 px-4 border border-gray-300 rounded-lg" rows="4" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keunggulan Produk</label>
                            <div class="flex items-center space-x-4">
                                <label><input type="checkbox" name="produk[${i}][keunggulan][]" value="Sertifikasi Halal"> Sertifikasi Halal</label>
                                <label><input type="checkbox" name="produk[${i}][keunggulan][]" value="Great Quality"> Great Quality</label>
                                <label><input type="checkbox" name="produk[${i}][keunggulan][]" value="Best Seller"> Best Seller</label>
                                <label><input type="checkbox" name="produk[${i}][keunggulan][]" value="Affordable Price"> Affordable Price</label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }
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
  <a href="admintentang.php" class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md">
    <i class="fas fa-newspaper mr-3"></i>
    <span>Tentang</span>
  </a>
</nav>

    </div>
    <div class="absolute bottom-0 p-6">
    <div class="flex items-center p-2 text-gray-600 hover:bg-gray-200 rounded-md w-58">
    <i class="fas fa-sign-out-alt mr-3"></i>
    <form action="" method="post">
        <input type="submit" name="logout" value="Logout" class="bg-transparent text-gray-600 hover:text-gray-900 cursor-pointer">
    </form>
</div>

     <p class="text-gray-400 text-sm mt-6">
      © KKNUQDesaKetanen
     </p>
    </div>
   </div>
    <div class="flex-1 p-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h1 class="text-2xl font-semibold mb-6">Tambah Produk</h1>

            <!-- Step 1: Input Jumlah Produk -->
            <form method="POST" action="" class="mb-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Produk</label>
                        <input id="jumlah_produk" type="number" name="jumlah_produk" class="w-full py-2 px-4 border border-gray-300 rounded-lg" min="1" required />
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="generateProductForms()" class="bg-teal-500 text-white px-4 py-2 rounded-md">Buat Form</button>
                    </div>
                </div>
            </form>

            <!-- Step 2: Generated Product Forms -->
            <form method="POST" action="">
                <input type="hidden" name="id_lapak" value="1"> <!-- Example lapak ID -->
                <div id="produk-forms"></div>
                <button type="submit" name="submit_produk" class="bg-teal-500 text-white px-4 py-2 rounded-md">Simpan Produk</button>
            </form>
        </div>
    </div>
  </div>
</body>
</html>
