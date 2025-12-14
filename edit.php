<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$id = $_GET['id'];
$res = $mysqli->query("SELECT * FROM makanan WHERE id=$id");
$data = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    $stmt = $mysqli->prepare(
        "UPDATE makanan SET nama=?, harga=?, stok=? WHERE id=?"
    );
    $stmt->bind_param("ssii", $nama, $harga, $stok, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Produk | Toko Barokah</title>
<style>
    body{
        margin:0;
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        font-family:'Poppins',sans-serif;
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
    }

    .edit-box{
        width:420px;
        background:white;
        padding:30px;
        border-radius:20px;
        box-shadow:0 12px 30px rgba(0,0,0,.25);
        animation:fade .4s ease;
    }

    @keyframes fade{
        from{opacity:0; transform:translateY(20px);}
        to{opacity:1; transform:translateY(0);}
    }

    h2{
        text-align:center;
        margin-bottom:25px;
        color:#1e90ff;
        font-weight:800;
    }

    label{
        font-size:14px;
        font-weight:700;
        color:#444;
    }

    input{
        width:100%;
        padding:12px;
        margin:6px 0 16px;
        border-radius:12px;
        border:1px solid #ccc;
        font-size:14px;
    }

    input:focus{
        outline:none;
        border-color:#2ecc71;
        box-shadow:0 0 0 3px rgba(46,204,113,.25);
    }

    .btn-area{
        display:flex;
        gap:12px;
        margin-top:10px;
    }

    .btn{
        flex:1;
        padding:12px;
        border:none;
        border-radius:14px;
        font-weight:800;
        cursor:pointer;
        text-decoration:none;
        text-align:center;
        transition:.25s;
    }

    .btn-back{
        background:#ecf0f1;
        color:#1e90ff;
        border:2px solid #1e90ff;
    }

    .btn-save{
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
        color:white;
        box-shadow:0 6px 15px rgba(0,0,0,.25);
    }

    .btn:hover{
        transform:translateY(-2px);
        opacity:.95;
    }
</style>
</head>

<body>

<div class="edit-box">
    <h2>✏️ Edit Produk</h2>

    <form method="post">
        <label>Nama Produk</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

        <label>Harga</label>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" value="<?= $data['stok'] ?>" required>

        <div class="btn-area">
            <a href="index.php" class="btn btn-back">⬅ Kembali</a>
            <button type="submit" class="btn btn-save">💾 Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
