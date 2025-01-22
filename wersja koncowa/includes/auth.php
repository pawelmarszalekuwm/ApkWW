<?php
session_start();
// Globalne włączenie pliku db_connect.php
include('db_connect.php');

// Funkcja logowania
function login($username, $password) {
    global $conn; // Użyj globalnego połączenia

    // Pobierz dane użytkownika z bazy
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

// Funkcja sprawdzająca zalogowanie
function check_login() {
    if (!isset($_SESSION['loggedin'])) {
        //header("Location: login.php");
        exit();
    }
}

// Funkcja wylogowania
function logout() {
    session_start();
    session_destroy();
    header("Location: login.php");
}

?>
