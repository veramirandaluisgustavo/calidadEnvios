<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/tables.css"> 
    <title>Orders - LA7AGLI</title>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="../public/images/logo_blue.png" alt="logo">
            <h1>LA7AGLI</h1>
        </div>
        <div class="nav-buttons">
            <a href="./landing.php">
                <div class="button">Home</div>
            </a>
            <a href="./login.php">
                <div class="button">Log In</div>
            </a>
        </div>
    </nav>
    
    <main>
        <h2>Search Clients</h2>
        <form id="search-form" method="post" action="orders.php">
            <label for="search">Enter client name:</label>
            <input type="text" id="search" name="search" placeholder="Enter client name..." value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
            <input type="submit" value="Search">
        </form>

        <?php
        include '../controllers/showClients.php';  
        echo $output; 
        ?>
    </main>
</body>
</html>
