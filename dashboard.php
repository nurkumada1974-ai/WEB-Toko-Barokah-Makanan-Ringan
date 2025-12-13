<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}
require 'db.php';

$items = $mysqli->query("SELECT * FROM makanan");
$total_barang = $items->num_rows;

$stok_sum = $mysqli->query("SELECT SUM(stok) AS total FROM makanan")->fetch_assoc()['total'] ?? 0;
$harga_min = $mysqli->query("SELECT MIN(harga) AS hmin FROM makanan")->fetch_assoc()['hmin'] ?? 0;
$harga_max = $mysqli->query("SELECT MAX(harga) AS hmax FROM makanan")->fetch_assoc()['hmax'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard | Toko Barokah</title>
<style>
    body{
        font-family:'Poppins',sans-serif;
        margin:0;
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
        display:flex;
    }

    /* SIDEBAR */
    .sidebar{
        width:230px;
        background:linear-gradient(180deg,#1e90ff,#2ecc71);
        padding:25px;
        height:100vh;
        position:fixed;
        border-radius:0 25px 25px 0;
        color:white;
        box-shadow:4px 0 15px rgba(0,0,0,.25);
    }

    .sidebar h2{
        text-align:center;
        margin-bottom:25px;
        font-weight:800;
    }

    .side-menu a{
        display:block;
        padding:12px 16px;
        margin-bottom:14px;
        background:white;
        color:#1e90ff;
        border-radius:14px;
        text-decoration:none;
        font-weight:700;
        transition:.25s;
    }

    .side-menu a:hover{
        background:#e8f6ff;
        transform:translateX(6px);
    }

    /* LOGOUT – DISAMAKAN */
    .logout-btn{
        position:absolute;
        bottom:60px; /* tidak mentok bawah */
        left:20px;
        right:20px;
        padding:14px;
        background:linear-gradient(135deg,#ff4d4d,#d90429);
        color:white;
        text-align:center;
        border-radius:14px;
        text-decoration:none;
        font-weight:800;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
        box-shadow:0 8px 18px rgba(217,4,41,.45);
        transition:.25s;
    }

    .logout-btn:hover{
        transform:translateY(-3px);
        box-shadow:0 12px 22px rgba(217,4,41,.65);
    }

    /* CONTENT */
    .content{
        margin-left:260px;
        padding:35px;
        width:calc(100% - 260px);
    }

    h1{
        color:white;
        margin-bottom:30px;
        font-weight:800;
    }

    /* CARDS */
    .cards{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:25px;
    }

    .card{
        background:white;
        padding:25px;
        border-radius:22px;
        text-decoration:none;
        color:black;
        box-shadow:0 8px 20px rgba(0,0,0,.25);
        transition:.3s;
        position:relative;
        overflow:hidden;
    }

    .card:hover{
        transform:translateY(-10px);
    }

    .card-icon{
        position:absolute;
        top:-15px;
        right:-15px;
        font-size:70px;
        opacity:.15;
    }

    .card h3{
        margin:0;
        font-size:17px;
        color:#555;
    }

    .card p{
        font-size:30px;
        font-weight:800;
        margin:6px 0;
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
    }

    .blue{border-left:10px solid #1e90ff;}
    .green{border-left:10px solid #2ecc71;}
    .yellow{border-left:10px solid #27ae60;}
    .red{border-left:10px solid #16a085;}

    /* BUTTON BAWAH */
    .action-btns{
        margin-top:45px;
        display:flex;
        gap:20px;
    }

    .btn-primary{
        padding:14px 26px;
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
        color:white;
        border-radius:16px;
        text-decoration:none;
        font-weight:800;
        box-shadow:0 6px 16px rgba(0,0,0,.25);
    }

    .btn-outline{
        padding:14px 26px;
        background:white;
        color:#1e90ff;
        border:2px solid #1e90ff;
        border-radius:16px;
        text-decoration:none;
        font-weight:800;
    }
</style>
</head>

<body>

<div class="sidebar">
    <h2>Toko Barokah</h2>

    <div class="side-menu">
        <a href="dashboard.php" style="background:#e8f6ff;">Dashboard</a>
        <a href="index.php">Daftar Produk</a>
        <a href="add.php">Tambah Produk</a>
    </div>

    <a href="logout.php" class="logout-btn">🚪 Logout</a>
</div>

<div class="content">

<h1>Dashboard</h1>

<div class="cards">

    <a href="index.php" class="card blue">
        <i class="card-icon">📦</i>
        <h3>Total Barang</h3>
        <p><?= $total_barang ?></p>
    </a>

    <a href="index.php" class="card green">
        <i class="card-icon">📊</i>
        <h3>Total Stok</h3>
        <p><?= $stok_sum ?> Unit</p>
    </a>

    <a href="index.php?sort=harga_asc" class="card yellow">
        <i class="card-icon">⬇️</i>
        <h3>Harga Termurah</h3>
        <p>Rp<?= number_format($harga_min,0,',','.') ?></p>
    </a>

    <a href="index.php?sort=harga_desc" class="card red">
        <i class="card-icon">⬆️</i>
        <h3>Harga Termahal</h3>
        <p>Rp<?= number_format($harga_max,0,',','.') ?></p>
    </a>

</div>

<div class="action-btns">
    <a href="add.php" class="btn-primary">➕ Tambah Produk</a>
    <a href="index.php" class="btn-outline">📄 Daftar Produk</a>
</div>

</div>
</body>
</html>
