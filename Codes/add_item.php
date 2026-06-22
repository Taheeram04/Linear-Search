
<?php
session_start();
if ($_SESSION['role'] !== 'admin') { exit(); }

$conn = new mysqli("localhost", "db_user", "db_pass", "food_ordering");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);

    // Handle image upload
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    $stmt = $conn->prepare("INSERT INTO menu_items (name, price, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $image_path);
    $stmt->execute();
    header("Location: admin_dashboard.php");
}
?>



<form method="POST" enctype="multipart/form-data">
    Name: <input name="name" required><br>
    Price: <input name="price" required><br>
    Image: <input type="file" name="image"><br>
    <button type="submit">Add Item</button>
</form>
