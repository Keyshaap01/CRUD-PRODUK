<?php
require "db.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if ($id && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php?status=hapus");
    exit;
}
header("Location: index.php");
exit;
?>