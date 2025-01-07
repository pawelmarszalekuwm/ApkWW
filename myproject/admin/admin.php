<?php
session_start();
echo '<pre>';
print_r($_SESSION);  // Wyświetli aktualny stan sesji
echo '</pre>';
include '../cfg.php';

function FormularzLogowania($error = '') {
    echo '<form method="post" action="admin.php">';
    if ($error) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    echo '<label for="login">Login:</label>
          <input type="text" id="login" name="login" required>
          <label for="pass">Hasło:</label>
          <input type="password" id="pass" name="pass" required>
          <input type="submit" value="Zaloguj">
          </form>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($login === $cfg_login && $pass === $cfg_pass) {
        $_SESSION['zalogowany'] = true;
    } else {
        FormularzLogowania('Nieprawidłowy login lub hasło.');
        exit;
    }
}

if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
    FormularzLogowania();
    exit;
}

function ListaPodstron() {
    global $conn;

    $query = "SELECT id, page_title FROM page_list";
    $stmt = $conn->query($query);

    echo '<h2>Lista podstron</h2>';
    echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Akcje</th>
            </tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['page_title']) . '</td>
                <td>
                    <a href="admin.php?akcja=edytuj&id=' . htmlspecialchars($row['id']) . '">Edytuj</a>
                    <a href="admin.php?akcja=usun&id=' . htmlspecialchars($row['id']) . '">Usuń</a>
                </td>
              </tr>';
    }
    echo '</table>';
    echo '<a href="admin.php?akcja=dodaj">Dodaj nową podstronę</a>';
}

function EdytujPodstrone($id) {
    global $conn;

    // Obsługa formularza po wysłaniu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page_title = $_POST['page_title'] ?? '';  // Tytuł strony
        $page_content = $_POST['page_content'] ?? '';  // Treść strony
        $status = isset($_POST['status']) ? 1 : 0;  // Aktywność strony (1 - aktywna, 0 - nieaktywna)

        // Aktualizacja danych w bazie
        $query = "UPDATE page_list SET page_title = :page_title, page_content = :page_content, status = :status WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':page_title', $page_title);
        $stmt->bindValue(':page_content', $page_content);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        exit;
    } else {
        // Pobranie danych o podstronie z bazy
        $query = "SELECT page_title, page_content, status FROM page_list WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Formularz edycji podstrony
    echo '<h2>Edytuj podstronę</h2>';
    echo '<form method="post" action="admin.php?akcja=edytuj&id=' . htmlspecialchars($id) . '">
            <label for="page_title">Tytuł:</label>
            <input type="text" id="page_title" name="page_title" value="' . htmlspecialchars($row['page_title']) . '" required>
            
            <label for="page_content">Treść:</label>
            <textarea id="page_content" name="page_content" required>' . htmlspecialchars($row['page_content']) . '</textarea>
            
            <label for="status">Aktywna:</label>
            <input type="checkbox" id="status" name="status" ' . ($row['status'] ? 'checked' : '') . '>

            <input type="submit" value="Zapisz zmiany">
          </form>';
}


function DodajNowaPodstrone() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page_title = $_POST['page_title'] ?? '';
        $page_content = $_POST['page_content'] ?? '';
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (:page_title, :page_content, :status)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':page_title', $page_title);
        $stmt->bindValue(':page_content', $page_content);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: admin.php');
        exit;
    }

    echo '<form method="post" action="admin.php?akcja=dodaj">
            <label for="page_title">Tytuł:</label>
            <input type="text" id="page_title" name="page_title" required>
            <label for="page_content">Treść:</label>
            <textarea id="page_content" name="page_content" required></textarea>
            <label for="status">Aktywna:</label>
            <input type="checkbox" id="status" name="status">
            <input type="submit" value="Dodaj podstronę">
          </form>';
}

function UsunPodstrone($id) {
    global $conn;

    $query = "DELETE FROM page_list WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: admin.php');
    exit;
}

if (isset($_GET['akcja'])) {
    $akcja = $_GET['akcja'];

    if ($akcja === 'edytuj' && isset($_GET['id'])) {
        EdytujPodstrone((int)$_GET['id']);
    } elseif ($akcja === 'dodaj') {
        DodajNowaPodstrone();
    } elseif ($akcja === 'usun' && isset($_GET['id'])) {
        UsunPodstrone((int)$_GET['id']);
    } else {
        ListaPodstron();
    }
} else {
    ListaPodstron();
}

if (isset($_GET['akcja']) && $_GET['akcja'] === 'wyloguj') {
    session_start(); // Upewnij się, że sesja jest inicjalizowana
    session_unset(); // Usuń wszystkie zmienne sesji
    session_destroy(); // Zniszcz sesję
    header('Location: ../index.php'); // Przekierowanie na stronę główną
    exit;
}

echo '<a href="/myproject/index.php?id=1">Strona glowna</a>';
echo '<a href="admin.php?akcja=wyloguj">Wyloguj</a>';
?>