<?php
include('../includes/auth.php');
check_login();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admina</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Witaj w Panelu Admina</h1>
        <nav>
            <ul>
                <li><a href="categories.php">Kategorie</a></li>
                <li><a href="products.php">Produkty</a></li>
                <li><a href="logout.php">Wyloguj się</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
