<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$password) {
        echo "<script>
            alert('Both username and password are required.');
            window.location.href = 'login.html';
        </script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE name = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Store user details in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $name;
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                echo "<script>
                    alert('Login successful!');
                    window.location.href = 'admin.php';
                </script>";
            } else {
                echo "<script>
                    alert('Login successful!');
                    window.location.href = 'mainpage.php';
                </script>";
            }
            exit;
        } else {
            echo "<script>
                alert('Invalid password.');
                window.location.href = 'login.html';
            </script>";
        }
    } else {
        echo "<script>
            alert('User not found.');
            window.location.href = 'login.html';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
