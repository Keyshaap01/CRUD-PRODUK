<?php
require "db.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header("Location: index.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();
if (!$produk) {
    http_response_code(404);
    exit("Produk tidak ditemukan. <a href='index.php'>Kembali</a>");
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama_produk"] ?? "");
    $harga = trim($_POST["harga"] ?? "");
    $stok = trim($_POST["stok"] ?? "");
    $deskripsi = trim($_POST["deskripsi"] ?? "");

    if ($nama === "" || $harga === "" || $stok === "") {
        $error = "Nama produk, harga, dan stok wajib diisi.";
    } elseif (!is_numeric($harga) || (float)$harga < 0) {
        $error = "Harga harus berupa angka nol atau lebih.";
    } elseif (filter_var($stok, FILTER_VALIDATE_INT) === false || (int)$stok < 0) {
        $error = "Stok harus berupa bilangan bulat nol atau lebih.";
    } else {
        $stmt = $pdo->prepare("UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, deskripsi = ? WHERE id = ?");
        $stmt->execute([$nama, $harga, $stok, $deskripsi, $id]);
        header("Location: index.php?status=edit");
        exit;
    }
    $produk["nama_produk"] = $nama;
    $produk["harga"] = $harga;
    $produk["stok"] = $stok;
    $produk["deskripsi"] = $deskripsi;
}
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8"); }
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container narrow">
    <a class="back" href="index.php">← Kembali ke daftar produk</a>
    <section class="panel form-panel">
        <p class="eyebrow">DATA PRODUK</p>
        <h1>Edit Produk</h1>
        <p class="subtitle">Perbarui informasi produk.</p>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" action="edit.php?id=<?= (int)$id ?>">
            <label>Nama produk <span>*</span>
                <input type="text" name="nama_produk" value="<?= e($produk["nama_produk"]) ?>" required maxlength="150">
            </label>
            <label>Harga (Rp) <span>*</span>
                <input type="number" name="harga" value="<?= e($produk["harga"]) ?>" min="0" step="1" required>
            </label>
            <label>Stok <span>*</span>
                <input type="number" name="stok" value="<?= e($produk["stok"]) ?>" min="0" step="1" required>
            </label>
            <label>Deskripsi
                <textarea name="deskripsi" rows="4"><?= e($produk["deskripsi"]) ?></textarea>
            </label>
            <div class="form-actions">
                <a class="button secondary" href="index.php">Batal</a>
                <button class="button" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>