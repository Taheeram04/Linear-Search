<?php
session_start();
if ($_SESSION['role'] !== 'admin') { exit(); }

$conn = new mysqli("localhost", "db_user", "db_pass", "food_ordering");
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM menu_items WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $conn->query("UPDATE menu_items SET name='$name', price=$price WHERE id=$id");
    header("Location: admin_dashboard.php");
}
?>

<form method="POST">
    Name: <input name="name" value="<?= $row['name'] ?>" required><br>
    Price: <input name="price" value="<?= $row['price'] ?>" required><br>
    <button type="submit">Update</button>
</form>
