<?php
session_start();
if ($_SESSION['role'] !== 'admin') { exit(); }

$conn = new mysqli("localhost", "db_user", "db_pass", "food_ordering");
$id = intval($_GET['id']);
$conn->query("DELETE FROM menu_items WHERE id = $id");
header("Location: admin_dashboard.php");
?>
