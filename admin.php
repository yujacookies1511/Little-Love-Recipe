<?php
// Database connection setup
$conn = new mysqli('localhost', 'root', '', 'littleloverecipe');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Fetch all users
$sqlUsers = "SELECT * FROM users";
$resultUsers = $conn->query($sqlUsers);

$users = [];
if ($resultUsers->num_rows > 0) {
    while($row = $resultUsers->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch all recipes
$sqlRecipes = "SELECT title, serving, cook_time, category FROM recipes";
$resultRecipes = $conn->query($sqlRecipes);

$recipes = [];
if ($resultRecipes->num_rows > 0) {
    while($row = $resultRecipes->fetch_assoc()) {
        $recipes[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        main {
            padding: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        section {
            margin-bottom: 2rem;
        }

        h2 {
            border-bottom: 2px solid #343a40;
            padding-bottom: 0.5rem;
            color: #343a40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            padding: 0.5rem 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td>
                                    <a href="#" class="button">Edit</a>
                                    <a href="#" class="button" style="background-color: #dc3545;">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h2>Recipe List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Serving</th>
                        <th>Cook Time (minutes)</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recipes)): ?>
                        <?php foreach ($recipes as $recipe): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                                <td><?php echo htmlspecialchars($recipe['serving']); ?></td>
                                <td><?php echo htmlspecialchars($recipe['cook_time']); ?></td>
                                <td><?php echo htmlspecialchars($recipe['category']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No recipes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

