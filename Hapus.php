<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Produk.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $id = $_POST['id'];

    if (!ctype_digit($id)) {
        header('Location: Index.php?pesan=id-tidak-valid');
        exit;
    }

    $db = new Database(); 
    $pdo = $db->getConnection(); 
    $produkModel = new Produk($pdo);


    $produk = $produkModel->cari($id);

    if ($produk) {

        $produkModel->hapus($id);
        header('Location: Index.php?pesan=hapus');
    } else {
        header('Location: Index.php?pesan=tidak-ditemukan');
    }
    exit;
}

header('Location: Index.php');
exit;
