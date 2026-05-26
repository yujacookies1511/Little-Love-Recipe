<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!$name || !$email || !$password || !$confirmPassword) {
        echo 'All fields are required.';
        exit;
    }

    if ($password !== $confirmPassword) {
        echo 'Passwords do not match.';
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>
            alert('Signup successful!');
            window.location.href = 'login.html';
            </script>";
            exit;
        } else {
            if ($conn->errno === 1062) {
                echo 'Email already exists.';
            } else {
                echo 'Error: ' . $stmt->error;
            }
        }
        $stmt->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    } finally {
        $conn->close();
    }
}
?>