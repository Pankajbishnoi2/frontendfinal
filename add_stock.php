<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'navbar.php';
 ?>


<?php
$conn = new mysqli('localhost', 'root', '', 'multi_shop_stock');

$table = $_POST['table'];
$item_name = $_POST['item_name'];
$quantity = $_POST['quantity'];

$conn->query("INSERT INTO `$table` (item_name, quantity) VALUES ('$item_name', $quantity)");

header("Location: stock.php?table=$table");
?>