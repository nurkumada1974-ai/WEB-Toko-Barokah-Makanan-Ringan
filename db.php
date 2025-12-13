<?php
$mysqli = new mysqli('localhost', 'root', '', 'tokobarokah');
if ($mysqli->connect_errno) {
die('Gagal koneksi: ' . $mysqli->connect_error);
}
?>