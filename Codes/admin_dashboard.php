<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

$conn = new mysqli("localhost", "db_user", "db_pass", "food_ordering");
$result = $conn->query("SELECT * FROM menu_items");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin </h2>
    <a href="add_item.php">➕ Add New Item</a>
    <table border="1">
        <tr>
            <th>Name</th><th>Price</th><th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td>KES <?= $row['price'] ?></td>
            <td>
                <a href="edit_item.php?id=<?= $row['id'] ?>"> Edit</a> |
                <a href="delete_item.php?id=<?= $row['id'] ?>"> Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
