<?php
require 'db.php';
$id = $_GET['id'];
$mysqli->query("DELETE FROM makanan WHERE id = $id");
header('Location: dashboard.php');
exit;
?>