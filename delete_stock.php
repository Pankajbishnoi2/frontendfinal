<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
 ?>

<?php
$conn = new mysqli('localhost', 'root', '', 'multi_shop_stock');

$id = $_GET['id'];
$table = $_GET['table'];
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('You are not allowed to make changes in the  database'); window.location.href = 'stock.php?table=$table';</script>";
    exit;
}
$conn->query("DELETE FROM `$table` WHERE id = $id");

header("Location: stock.php?table=$table");
?>