<?php
require 'db.php';

// Buat folder uploads jika belum ada
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $gambar = "";

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $filename = time() . "_" . rand(1000,9999) . "." . $ext;
        $target = "uploads/" . $filename;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $gambar = $filename;
        } else {
            die("Gagal upload gambar");
        }
    } else {
        die("Gambar belum dipilih");
    }

    $stmt = $mysqli->prepare(
        "INSERT INTO makanan (nama, harga, stok, gambar) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param('ssss', $nama, $harga, $stok, $gambar);
    $stmt->execute();

    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
<style>
    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1e90ff, #2ecc71);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 420px;
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        animation: fadeIn 0.5s ease;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #1e90ff;
    }

    label {
        font-weight: bold;
        color: #444;
        font-size: 14px;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 6px 0 14px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    /* DROPZONE */
    .dropzone {
        border: 2px dashed #1e90ff;
        padding: 20px;
        text-align: center;
        border-radius: 12px;
        background: #f0f9ff;
        cursor: pointer;
        margin-bottom: 15px;
        transition: 0.2s;
    }

    .dropzone:hover {
        background: #e6f4ff;
    }

    #preview {
        display: none;
        margin-top: 10px;
    }

    #preview img {
        width: 100%;
        border-radius: 12px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #1e90ff, #2ecc71);
        border: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: 0.2s;
    }

    button:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* TOMBOL BAWAH */
    .bottom-actions {
        margin-top: 25px;
        display: flex;
        gap: 12px;
    }

    .bottom-btn {
        flex: 1;
        padding: 12px;
        text-align: center;
        border-radius: 14px;
        font-weight: bold;
        text-decoration: none;
        color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.25);
        transition: 0.25s;
    }

    .dashboard-btn {
        background: linear-gradient(135deg, #1e90ff, #4facfe);
    }

    .produk-btn {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
    }

    .bottom-btn:hover {
        transform: translateY(-3px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
</head>

<body>

<div class="container">
    <h2>➕ Tambah Produk</h2>

    <form method="post" enctype="multipart/form-data">

        <label>Nama Produk</label>
        <input type="text" name="nama" required>

        <label>Harga</label>
        <input type="number" name="harga" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <div class="dropzone" id="dropzone">
            <p>📷 Klik / Drag gambar ke sini</p>
        </div>

        <input type="file" name="gambar" id="gambar" hidden accept="image/*">

        <div id="preview">
            <img id="imgPreview">
        </div>

        <button type="submit">💾 Simpan Produk</button>
    </form>

    <!-- TOMBOL NAVIGASI -->
    <div class="bottom-actions">
        <a href="dashboard.php" class="bottom-btn dashboard-btn">📊 Dashboard</a>
        <a href="index.php" class="bottom-btn produk-btn">📦 Daftar Produk</a>
    </div>
</div>

<script>
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('gambar');
const preview = document.getElementById('preview');
const imgPreview = document.getElementById('imgPreview');

dropzone.onclick = () => fileInput.click();
fileInput.onchange = () => showPreview(fileInput.files[0]);

dropzone.ondragover = e => {
    e.preventDefault();
    dropzone.style.background = "#e6f4ff";
};

dropzone.ondragleave = () => {
    dropzone.style.background = "#f0f9ff";
};

dropzone.ondrop = e => {
    e.preventDefault();
    fileInput.files = e.dataTransfer.files;
    showPreview(e.dataTransfer.files[0]);
};

function showPreview(file){
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        preview.style.display = 'block';
        imgPreview.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>
