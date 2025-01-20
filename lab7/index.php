<?php
session_start();
// Dołącz plik konfiguracji bazy danych i funkcji
include 'cfg.php';
include 'showpage.php';

// Sprawdź, czy parametr 'id' został przekazany w URL, w przeciwnym razie ustaw domyślnie ID=1
$page_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Pobierz zawartość strony z bazy danych
$page_content = PokazPodstrone($page_id);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmy Oscarowe</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/tryb_nocny.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/animation.js"></script>
    
</head>
<body onload="startClock()">
    <header>
        <h1>Filmy, które otrzymały Oscara</h1>
        <div id="zegarek"></div>
        <div id="data"></div>
    </header>
    
        <nav>
            <ul>
                <li><a href="index.php?id=1">Strona Główna</a></li>
                <li><a href="index.php?id=2">Władca Pierścieni: Powrót Króla</a></li>
                <li><a href="index.php?id=3">Terminator 2: Dzień Sądu</a></li>
                <li><a href="index.php?id=4">Ratatouille</a></li>
                <li><a href="index.php?id=5">Oppenheimer</a></li>
                <li><a href="index.php?id=6">Infiltracja</a></li>
                <li><a href="index.php?id=7">Filmy</a></li>
                <li><a href="index.php?id=8">Kontakt</a></li>
                <li><a href="admin/admin.php">Zaloguj</a></li>
                <button onclick="toggleNightMode()">Tryb Nocny</button>
            </ul>
        </nav>
    </header>
    <main>
        <div class="content">
            <?php
            // Wyświetl zawartość strony pobraną z bazy danych
            echo $page_content;
            ?>
        </div>
    </main>
    <footer>
        <p>© 2025 Moja Strona. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
