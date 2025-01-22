<?php
$servername = "localhost";
$username = "root";  // domyślny użytkownik w XAMPP
$password = "";      // domyślne hasło (puste)
$dbname = "cms_db";  // nazwa bazy danych

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
