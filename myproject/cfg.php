<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Rozpoczęcie sesji, jeśli jeszcze nie jest aktywna
}
$servername = 'localhost';
$username = 'root';
$password = '';

try {
  $conn = new PDO("mysql:host=$servername;dbname=moja_strona", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$cfg_login = "pass"; // Login administratora
$cfg_pass = "pass"; // Hasło administratora
?>