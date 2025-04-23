<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'navbar.php'; ?>

<?php
$conn = new mysqli('localhost', 'root', '', 'multi_shop_stock');

$table = $_GET['table'] ?? '';
if (!$table) {
    echo "No shop selected.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock - <?= htmlspecialchars($table) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fb;
            color: #333;
            margin: 0;
            padding:20px;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 200px;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
            
        }

        tr:hover {
            background-color: #e6f0ff;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            margin: 0 5px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Stock for <?= htmlspecialchars($table) ?></h2>

<h3>Add New Item</h3>
<form method="POST" action="add_stock.php">
    <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
    <input type="text" name="item_name" placeholder="Item Name" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <button type="submit">Add</button>
</form>

<table>
    <tr>
        <th>S.No.</th>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM `$table`");
    $serial = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>$serial</td>
            <td>{$row['item_name']}</td>
            <td>{$row['quantity']}</td>
            <td>
                <a href='update_stock.php?table=$table&id={$row['id']}'>Edit</a> |
                <a href='delete_stock.php?table=$table&id={$row['id']}'>Delete</a>
            </td>
        </tr>";
        $serial++;
    }
    ?>
</table>

</body>
</html>
