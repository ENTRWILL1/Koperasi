<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Produk.php';

$id = $_GET['id'] ?? '';

if (!ctype_digit($id)) {
    header('Location: Index.php?pesan=id-tidak-valid');
    exit;
}

$db = new Database(); 
$pdo = $db->getConnection(); 
$produkModel = new Produk($pdo);

$project = $produkModel->cari($id);

if (!$project) {
    header('Location: Index.php?pesan=tidak-ditemukan');
    exit;
}

$nama = $project['nama'];
$harga = $project['harga'];
$stok = $project['stok'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $stok = trim($_POST['stok'] ?? '');

    if ($nama === '') {
        $errors['nama'] = 'Nama wajib diisi.';
    } elseif (mb_strlen($nama) > 50) {
        $errors['nama'] = 'Nama maksimal 50 karakter.';
    }

    if ($harga === '') {
        $errors['harga'] = 'Harga wajib diisi.';
    }

    if ($stok === '') {
        $errors['stok'] = 'Stok wajib diisi.';
    }

    if (empty($errors)) {

        $produkModel->ubah($id, $nama, $harga, $stok);

        header('Location: Index.php?pesan=ubah');
        exit;
    }
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<h2>Edit Produk</h2>
<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post">

    <label>Nama :</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" required><br><br>
    
    <label>Harga :</label>
    <input type="number" name="harga" value="<?= htmlspecialchars($harga) ?>" required><br><br>
    
    <label>Stok :</label>
    <input type="number" name="stok" value="<?= htmlspecialchars($stok) ?>" required><br><br>
    
    <button type="submit">Simpan</button>
    <a href="Index.php">Batal</a>
</form>
