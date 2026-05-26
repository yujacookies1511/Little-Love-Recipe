<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$database = "littleloverecipe"; // Replace with your database name

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add a new item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $user_id = 1; // Example user ID
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $quantity = (int)$_POST['quantity'];

    $query = "INSERT INTO shopping_list (user_id, item_name, quantity) VALUES ($user_id, '$item_name', $quantity)";
    mysqli_query($conn, $query);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Soft delete an item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_item'])) {
    $id = (int)$_POST['id'];
    $query = "UPDATE shopping_list SET deleted_at = NOW() WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Restore a deleted item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_item'])) {
    $id = (int)$_POST['id'];
    $query = "UPDATE shopping_list SET deleted_at = NULL WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <title>Shopping List</title>
    <style>
        /* General styles */
        /* Ensure the entire page uses full height */
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
    font-family:Arial, Helvetica, sans-serif;
}

/* Main container takes up all available space */
.container {
    margin-top: 100px;
    flex: 1; /* Push the footer to the bottom */
}

        h1, h2 {
            margin-top: 40px;
            text-align: center;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            flex: 1; /* Push the footer to the bottom */
        }

        .form-container {
            margin-top: 80px;
            text-align: center;
            margin-bottom: 30px;
            
        }

        form input[type="text"],
        form input[type="number"] {
            padding: 10px;
            width: 200px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            padding: 10px 20px;
            color: white;
            background-color: #ff5722;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        form button:hover {
            background-color: #e64a19;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Buttons in the table */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        .btn-restore {
            background-color: #4caf50;
            color: white;
        }

        .btn-restore:hover {
            background-color: #45a049;
        }

        /* Footer styles */
        footer {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            background-color: #ffe4e1;
            color: #555;
            border-top: 1px solid #ddd;
        }

        footer a {
            text-decoration: none;
            color: #f44336;
            margin: 0 5px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            form input[type="text"],
            form input[type="number"] {
                width: 100%;
            }

            form button {
                width: 100%;
                margin-top: 10px;
            }

            table, th, td {
                font-size: 14px;
            }
        }
   
        footer {
    background-color: #f8dada;
    text-align: center;
    padding: 15px 0;
    font-size: 14px;
    color: #555;
    border-top: 2px solid #ccc;
}

footer a {
    color: #ff6464;
    text-decoration: none;
    margin: 0 10px;
    transition: color 0.3s ease;
}

footer a:hover {
    color: #e05555;
}

    </style>
</head>
<body>
<header>
        <div class="logo">
            <a href="mainpage.php">
                <img src="images/LittleLoveRecipe_Logo.png" alt="Little Love Recipe Logo" class="logo-img">
            </a>
        </div>
    
        <!-- Responsive Navigation Menu -->
        <nav>
            <button class="menu-toggle" aria-label="Toggle Navigation">
                <span class="hamburger"></span>
            </button>
            <ul class="nav-links">
                <li><a href="mainpage.php">Home</a></li>
                <li><a href="php/categories.php">Categories</a></li>
                <li><a href="php/profilepage2.php">Profile</a></li>
            </ul>
        </nav>
    
        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Search recipes..." aria-label="Search" />
            <button type="button">🔍</button>
        </div>
    
        <!-- Notifications and Profile Menu -->
        <div class="user-controls">
            <div class="profile-menu">
                <img src="images/profile.png" alt="Profile" class="profile-pic" />
                <div class="dropdown">
                    <ul>
                        <li><a href="php/profilepage2.php">View Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
    <h1>Shopping List</h1>
    <div class="form-container">
        <form method="POST">
            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" required>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required>
            <button type="submit" name="add_item">Add Item</button>
        </form>
    </div>
    <h2>Active Items</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_id = 1; // Example user ID
            $query = "SELECT * FROM shopping_list WHERE user_id = $user_id AND deleted_at IS NULL ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['item_name']) . "</td>
                        <td>" . htmlspecialchars($row['quantity']) . "</td>
                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                        <td>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                <button type='submit' name='delete_item'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Deleted Items</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM shopping_list WHERE user_id = $user_id AND deleted_at IS NOT NULL ORDER BY deleted_at DESC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['item_name']) . "</td>
                        <td>" . htmlspecialchars($row['quantity']) . "</td>
                        <td>" . htmlspecialchars($row['deleted_at']) . "</td>
                        <td>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                <button class='restore-btn' type='submit' name='restore_item'>Restore</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    <footer>
        <p>
            © 2025 <strong>LittleLoveRecipe</strong>. All Rights Reserved.
        </p>
        <nav>
            <a href="about.html">About Us</a>
            <a href="contactus.html">Contact Us</a>
            
        </nav>
        <p>
            Contact us:
            <a href="https://facebook.com/pencinta.zikir" target="_blank" aria-label="Facebook">
                <img src="images/facebook.png" alt="Facebook" width="20">
            </a>
            
            <a href="https://www.instagram.com/sabreenahany/profilecard/?igsh=cHE2M2JwNWZ0czdp" target="_blank" aria-label="Instagram">
                <img src="images/instagram.png" alt="Instagram" width="20">
            </a>
        </p>
    </footer>
    <script src="js/header.js"></script>
</body>
</html>
