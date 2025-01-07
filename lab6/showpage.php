<?php
include 'cfg.php';
function PokazPodstrone($id) {
    global $conn; // Połączenie PDO, zdefiniowane w cfg.php

    // Czyszczenie ID (upewniamy się, że to liczba)
    $id_clear = intval($id);

    // Przygotowanie zapytania SQL
    $query = "SELECT * FROM page_list WHERE id = :id AND status = 1 LIMIT 1";
    $stmt = $conn->prepare($query); // Przygotowanie zapytania
    $stmt->bindValue(':id', $id_clear, PDO::PARAM_INT); // Powiązanie parametru

    $stmt->execute(); // Wykonanie zapytania
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Pobranie wyniku

    // Sprawdzenie, czy znaleziono podstronę
    if ($result) {
        return $result['page_content']; // Zwrócenie treści podstrony
    } else {
        return '[nie_znaleziono_strony]'; // Gdy strona nie istnieje
    }
}
?>
