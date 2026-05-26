
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('check_login.php');?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe App</title>
    <link rel="stylesheet" href="css/styles.css">
    
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
    
    <main>
        <div class="welcome-text">
            WELCOME TO LITTLE LOVE RECIPE
        </div>
        <div class="grid-container">
            <div class="grid-item">
                <img src="images/addrecipe.png" alt="Create Recipe">
                <p><a href="createrecipepage.html">Create Recipe</a></p>
            </div>
            <div class="grid-item">
                <img src="images/shoppinglist.png" alt="Shopping List">
                <p><a href="shoppinglist.php">Shopping List</a></p>
            </div>
            <div class="grid-item">
                <img src="images/fav.png" alt="Favorite">
                <p><a href="php/favourite.php">Favorite</a></p>
            </div>
            <div class="grid-item">
                <img src="images/myrecipe.png" alt="My Recipe">
                <p><a href="php/myrecipes.php">My Recipe</a></p>
            </div>
            <div class="grid-item">
                <img src="images/searchrecipe.png" alt="Search Recipe">
                <p><a href="php/search.php">Search Recipe</a></p>
            </div>
        </div>
    </main>
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