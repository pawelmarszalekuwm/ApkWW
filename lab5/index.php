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
    <div id="zegarek"></div>
    <div id="data"></div>
    <header>
        <h1>Filmy, które otrzymały Oscara</h1>
    </header>
    
    
    <nav>
        <ul>
            <li><a href="index.html">Strona Główna</a></li>
            <li><a href="html/Lotr.html">Władca Pierścieni: Powrót Króla</a></li>
            <li><a href="html/terminator-2.html">Terminator 2: Dzień Sądu</a></li>
            <li><a href="html/ratatuj.html">Ratatouille</a></li>
            <li><a href="html/oppenheimer.html">Oppenheimer</a></li>
            <li><a href="html/infiltracja.html">Infiltracja</a></li>
            <li><a href="html/kontakt.html">Kontakt</a></li>

        </ul>
    </nav>

    <main>
            <h2>Witamy na stronie o filmach nagrodzonych Oscarem!</h2>
            <button onclick="toggleNightMode()">Tryb Nocny</button>
            <p>Na tej stronie znajdziesz informacje o filmach, które zdobyły Oscara w różnych kategoriach.</p>
            <img id="oscar" src="img/oskar.png" alt="Statuetka Oscara">
    </main>
    <footer>
        <p>&copy; 2024 Filmy Oscarowe. Wszystkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
<?
 $nr_indeksu = '169335';
 $nrGrupy = '4';
 echo 'Autor: Paweł Marszałek '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
?>
