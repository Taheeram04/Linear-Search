<?php
session_start();
include 'db_connect.php';

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
}

// Delete product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
?>

<h2> Add New Product</h2>
<form method="POST">
  <input type="text" name="name" placeholder="Product Name" required>
  <input type="number" step="0.01" name="price" placeholder="Price" required>
  <button type="submit" name="add">Add Product</button>
</form>

<hr>

<h2> Product List</h2>
<?php
$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()) {
  echo "{$row['name']} - \${$row['price']} <a href='?delete={$row['id']}'>[Delete]</a><br>";
}
?>
