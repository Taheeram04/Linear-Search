<?php
// Database connection
$conn = new mysqli("localhost", "db_user", "db_pass", "food_ordering");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize POST inputs
$user_id = intval($_POST['user_id']);
$restaurant_id = intval($_POST['restaurant_id']);
$items = $_POST['items']; // array of [menu_item_id => qty]

// Create new order
$sql = "INSERT INTO orders (user_id, restaurant_id, status, timestamp, total_amount)
        VALUES (?, ?, 'pending', NOW(), 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $restaurant_id);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
$total = 0;
foreach ($items as $menu_item_id => $qty) {
    $menu_item_id = intval($menu_item_id);
    $qty = intval($qty);

    // Fetch item price
    $result = $conn->query("SELECT price FROM menu_items WHERE id = $menu_item_id");
    $row = $result->fetch_assoc();
    $price = $row['price'];
    $subtotal = $price * $qty;
    $total += $subtotal;

    $conn->query("INSERT INTO order_items (order_id, menu_item_id, quantity, price)
                  VALUES ($order_id, $menu_item_id, $qty, $price)");
}

// Update order total
$conn->query("UPDATE orders SET total_amount = $total WHERE id = $order_id");

echo "Order placed successfully! Order ID: $order_id";
?>
