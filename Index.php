<?php
// index.php

require_once "Database.php";
require_once "Produk.php";

$db = new Database(); // ambil kunci
$produkModel = new Produk($db->getConnection());

$kataKunci = $_GET['cari'] ?? '';

if ($kataKunci !== '') {

    $data = $produkModel->cariNama($kataKunci);
} else {

    $data = $produkModel->semua(); 
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<h2>Koperasi Sekolah</h2>

<?php if (isset($_GET['pesan'])): ?>
    <div style="background-color: #e2f0d9; color: #385723; padding: 8px; margin-bottom: 10px; display: inline-block;">
        <?php
        if ($_GET['pesan'] === 'ubah') echo "Produk berhasil diperbarui!";
        if ($_GET['pesan'] === 'hapus') echo "Produk berhasil dihapus!";
        if ($_GET['pesan'] === 'tidak-ditemukan') echo "Data tidak ditemukan.";
        if ($_GET['pesan'] === 'id-tidak-valid') echo "ID Produk tidak valid.";
        ?>
    </div>
    <br>
<?php endif; ?>

<a href="tambah.php">+ Tambah Produk</a>
<br><br>

<form method="get" action="index.php" style="margin-bottom: 15px;">
    <input type="text" name="cari" placeholder="Cari nama produk..." value="<?= htmlspecialchars($kataKunci) ?>">
    <button type="submit">Cari</button>
    <?php if ($kataKunci !== ''): ?>
        <a href="index.php">Reset</a>
    <?php endif; ?>
</form>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="5" align="center">Data produk tidak ditemukan.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td><?= $p['stok'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $p['id'] ?>">Edit</a> | 
                        
                        <form action="hapus.php" method="post" style="display:inline;" onsubmit="return confirm('Yakin hapus produk <?= htmlspecialchars($p['nama']) ?>?')">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" style="background:none; border:none; color:blue; cursor:pointer; text-decoration:underline; padding:0;">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
