<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}




$conn = new mysqli('localhost', 'root', '', 'multi_shop_stock');

$table = $_GET['table'];
$id = $_GET['id'];

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('You are not allowed'); window.location.href = 'stock.php?table=$table';</script>";
    exit;
}
?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    
    $conn->query("UPDATE `$table` SET item_name = '$item_name', quantity = $quantity WHERE id = $id");
    header("Location: stock.php?table=$table");
    exit;
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update - <?= htmlspecialchars($table) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f2f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            margin-bottom: 24px;
            color: #333;
            text-align: center;
        }

        .form-container input {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #2a5298;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #1e3c72;
        }
    </style>
</head>
<body>


<div class="form-container">
    
   
    <h2>Update Item (<?= htmlspecialchars($table) ?>)</h2>
    <form method="POST">
        <input type="text" name="item_name" value="<?= htmlspecialchars($row['item_name']) ?>" required>
        <input type="number" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required>
        
        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>
