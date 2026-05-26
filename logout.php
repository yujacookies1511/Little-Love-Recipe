<?php
session_start(); // Start the session

// Destroy the session to log out the user
session_destroy();

// Redirect to the login page or homepage
header("Location: login.html"); // Change this to your desired location, e.g., "index.html" for homepage
exit();
?>
