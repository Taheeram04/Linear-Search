<?php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'] ?? 1; // Replace or adjust if login is active
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "Your cart is empty.";
    exit;
}

// Calculate total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Insert into orders
$order_stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$order_stmt->bind_param("id", $user_id, $total);
$order_stmt->execute();
$order_id = $conn->insert_id;

// Insert each item
$item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($cart as $pid => $item) {
    $item_stmt->bind_param("iiid", $order_id, $pid, $item['quantity'], $item['price']);
    $item_stmt->execute();
}

unset($_SESSION['cart']); // Clear cart

echo " Order placed successfully! Your order ID is #$order_id.";
?>
