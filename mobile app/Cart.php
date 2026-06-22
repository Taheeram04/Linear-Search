<?php
session_start();
include 'db_connect.php';

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $id = $_POST['product_id'];
    $query = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $product = $result->fetch_assoc();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1
        ];
    } else {
        $_SESSION['cart'][$id]['quantity']++;
    }
}

// Remove from cart
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
?>

<h2> Product List</h2>
<?php
$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()) {
?>
<form method="POST" action="">
    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
    <p><?= $row['name'] ?> - $<?= $row['price'] ?></p>
    <button name="add">Add to Cart</button>
</form>
<?php } ?>

<hr>

<h2> Your Cart</h2>
<?php
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $item) {
        $subtotal = $item['price'] * $item['quantity'];
        echo "<p>{$item['name']} - {$item['quantity']} x \${$item['price']} = \$$subtotal 
        <a href='?remove=$id'>[Remove]</a></p>";
        $total += $subtotal;
    }
    echo "<p><strong>Total: $$total</strong></p>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>
