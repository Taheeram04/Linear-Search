<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_pw);
        $stmt->fetch();

        if (password_verify($password, $hashed_pw)) {
            $_SESSION['user_id'] = $user_id;
            echo "Logged in!";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Email not found.";
    }
// Example concept (requires storage like DB or session)
$_SESSION['login_attempts']++;
if ($_SESSION['login_attempts'] > 5) {
    echo "Too many attempts. Please try again later.";
    exit;
}

}
?>
