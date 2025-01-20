<?php
// Dane logowania
$login = "pass";
$pass = "pass";

// Dane do połączenia z bazą danych
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "moja_strona";

try {
    // Tworzenie połączenia PDO
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>
