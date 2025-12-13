<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}
require 'db.php';
$items = $mysqli->query("SELECT * FROM makanan");
?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Produk</title>
<style>
    body{
        margin:0;
        font-family:'Poppins',Arial,sans-serif;
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
        display:flex;
        min-height:100vh;
    }

    /* SIDEBAR */
    .sidebar{
        width:240px;
        background:linear-gradient(180deg,#1e90ff,#2ecc71);
        padding:25px;
        position:fixed;
        height:100vh;
        border-radius:0 20px 20px 0;
        box-shadow:4px 0 15px rgba(0,0,0,.25);
        color:white;
    }

    .sidebar h2{
        text-align:center;
        margin-bottom:30px;
        font-weight:800;
    }

    .side-menu a{
        display:block;
        padding:12px;
        margin-bottom:14px;
        background:white;
        color:#1e90ff;
        font-weight:700;
        border-radius:14px;
        text-decoration:none;
        text-align:center;
        transition:.25s;
    }

    .side-menu a:hover{
        background:#e6f4ff;
        transform:translateX(4px);
    }

    /* LOGOUT (NAIK DIKIT) */
    .logout-btn{
        position:absolute;
        bottom:60px; /* <<< TIDAK TERLALU BAWAH */
        left:20px;
        right:20px;
        padding:14px;
        background:linear-gradient(135deg,#ff4d4d,#d90429);
        color:white;
        text-align:center;
        border-radius:14px;
        font-weight:700;
        text-decoration:none;
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
        padding:30px;
        width:calc(100% - 260px);
    }

    h1{
        color:white;
        margin-bottom:20px;
        font-weight:800;
    }

    table{
        width:100%;
        border-collapse:collapse;
        background:white;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,.2);
    }

    th{
        background:linear-gradient(135deg,#1e90ff,#2ecc71);
        color:white;
        padding:15px;
        font-weight:800;
        text-align:left;
    }

    td{
        padding:14px;
        font-weight:600;
        border-bottom:1px solid #e0eefc;
    }

    tr:hover td{
        background:#eef7ff;
    }

    .produk-img{
        width:70px;
        height:70px;
        border-radius:12px;
        object-fit:cover;
        border:2px solid #1e90ff;
    }

    .action-btns{
        display:flex;
        gap:10px;
    }

    .btn{
        padding:8px 16px;
        border-radius:999px;
        font-weight:700;
        text-decoration:none;
        color:white;
        display:inline-flex;
        align-items:center;
        gap:6px;
        transition:.25s;
        font-size:13px;
    }

    .edit-btn{
        background:linear-gradient(135deg,#2ecc71,#27ae60);
    }

    .delete-btn{
        background:linear-gradient(135deg,#e63946,#c1121f);
    }

    .btn:hover{
        transform:translateY(-2px);
    }

    .bottom-actions{
        margin-top:30px;
        display:flex;
        gap:16px;
    }

    .bottom-btn{
        padding:14px 26px;
        border-radius:16px;
        font-weight:800;
        text-decoration:none;
        color:white;
        display:inline-flex;
        align-items:center;
        gap:10px;
        box-shadow:0 6px 18px rgba(0,0,0,.25);
        transition:.25s;
    }

    .produk-btn{
        background:linear-gradient(135deg,#1e90ff,#4facfe);
    }

    .tambah-btn{
        background:linear-gradient(135deg,#2ecc71,#27ae60);
    }

    .bottom-btn:hover{
        transform:translateY(-3px);
    }
</style>
</head>

<body>

<div class="sidebar">
    <h2>Toko Barokah</h2>

    <div class="side-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Daftar Produk</a>
        <a href="add.php">Tambah Produk</a>
    </div>

    <a class="logout-btn" href="logout.php">🚪 Logout</a>
</div>

<div class="content">
    <h1>📦 Daftar Produk</h1>

    <table>
        <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while($row=$items->fetch_assoc()): ?>
        <tr>
            <td><img class="produk-img" src="uploads/<?= $row['gambar'] ?>"></td>
            <td><?= $row['nama'] ?></td>
            <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <div class="action-btns">
                    <a class="btn edit-btn" href="edit.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                    <a class="btn delete-btn" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus produk?')">🗑️ Hapus</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="bottom-actions">
        <a href="dashboard.php" class="bottom-btn produk-btn">📊 Dashboard</a>
        <a href="add.php" class="bottom-btn tambah-btn">➕ Tambah Produk</a>
    </div>
</div>

</body>
</html>
