<?php
require "db.php";
$stmt = $pdo->query("SELECT id, nama_produk, harga, stok, deskripsi FROM produk ORDER BY id DESC");
$produk = $stmt->fetchAll();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <header class="topbar">
        <div>
            <p class="eyebrow">APLIKASI CRUD PHP & MYSQL</p>
            <h1>Manajemen Produk</h1>
            <p class="subtitle">Kelola data produk dengan mudah.</p>
        </div>
        <a class="button" href="tambah.php">+ Tambah Produk</a>
    </header>

    <?php if (isset($_GET["status"])): ?>
        <div class="alert">
            <?php
            $messages = [
                "tambah" => "Produk berhasil ditambahkan.",
                "edit" => "Produk berhasil diperbarui.",
                "hapus" => "Produk berhasil dihapus."
            ];
            echo e($messages[$_GET["status"]] ?? "Operasi selesai.");
            ?>
        </div>
    <?php endif; ?>

    <section class="panel">
        <div class="panel-heading">
            <h2>Daftar Produk</h2>
            <span class="count"><?= count($produk) ?> produk</span>
        </div>
        <?php if (!$produk): ?>
            <div class="empty">
                <h3>Belum ada produk</h3>
                <p>Tambahkan produk pertama untuk mulai menggunakan aplikasi.</p>
                <a class="button" href="tambah.php">Tambah Produk</a>
            </div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($produk as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="product-name"><?= e($p["nama_produk"]) ?></td>
                        <td>Rp <?= number_format((float)$p["harga"], 0, ",", ".") ?></td>
                        <td><?= (int)$p["stok"] ?></td>
                        <td><?= e($p["deskripsi"] ?: "-") ?></td>
                        <td>
                            <div class="actions">
                                <a class="button small secondary" href="edit.php?id=<?= (int)$p["id"] ?>">Edit</a>
                                <form action="hapus.php" method="post" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    <input type="hidden" name="id" value="<?= (int)$p["id"] ?>">
                                    <button class="button small danger" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </section>
    <footer>Praktikum Komputasi Awan · PHP Native + MySQL</footer>
</main>
</body>
</html>