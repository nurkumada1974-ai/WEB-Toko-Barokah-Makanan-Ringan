<?php
require 'db.php';

$id = $_GET['id'];
$res = $mysqli->query("SELECT * FROM makanan WHERE id = $id");
$data = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok']; // TAMBAHAN

    // UPDATE dengan stok
    $stmt = $mysqli->prepare("UPDATE makanan SET nama=?, harga=?, stok=? WHERE id=?");
    $stmt->bind_param('ssii', $nama, $harga, $stok, $id);
    $stmt->execute();

    header('Location: dashboard.php');
    exit;
}
?>
<html>
<body>
<h2>Edit Produk</h2>

<form method="post">
    Nama: <input type="text" name="nama" value="<?= $data['nama'] ?>"><br>
    Harga: <input type="number" name="harga" value="<?= $data['harga'] ?>"><br>

    <!-- INPUT STOK -->
    Stok: <input type="number" name="stok" value="<?= $data['stok'] ?>"><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
