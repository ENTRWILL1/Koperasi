<?php

require_once "Database.php";
require_once "Produk.php";

$db = new Database();
$produk = new Produk($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk->tambah($_POST['nama'], $_POST['harga'], $_POST['stok']);
    
    header("Location: index.php");
    exit;
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<h2>Tambah Produk</h2>

<form method="post">
    <label>Nama :</label>
    <input type="text" name="nama" required><br><br>
    
    <label>Harga :</label>
    <input type="number" name="harga" required><br><br>
    
    <label>Stok :</label>
    <input type="number" name="stok" required><br><br>
    
    <button type="submit">Simpan</button>
    <a href="index.php">Batal</a>
</form>