<?php
// admin.php
include '../cfg.php'; // Wczytanie konfiguracji bazy danych
session_start();

// Funkcja FormularzLogowania
function FormularzLogowania() {
    echo '<form method="post">
        <label>Login: <input type="text" name="login"></label><br>
        <label>Hasło: <input type="password" name="password"></label><br>
        <button type="submit" name="login_submit">Zaloguj</button>
    </form>';
}

if (isset($_POST['login_submit'])) {
    global $login, $pass; // Zmienne z cfg.php

    if ($_POST['login'] === $login && $_POST['password'] === $pass) {
        $_SESSION['logged_in'] = true;
    } else {
        echo '<p>Błędny login lub hasło</p>';
        FormularzLogowania();
        exit;
    }
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    FormularzLogowania();
    exit;
}

// Funkcja ListaPodstron
function ListaPodstron() {
    global $conn;

    try {
        $query = "SELECT id, page_title FROM page_list";
        $stmt = $conn->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>';
        foreach ($rows as $row) {
            echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . htmlspecialchars($row['page_title']) . '</td>
                <td>
                    <form method="post" style="display:inline;">
                        <button type="submit" name="edit" value="' . $row['id'] . '">Edytuj</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <button type="submit" name="delete" value="' . $row['id'] . '">Usuń</button>
                    </form>
                </td>
            </tr>';
        }
        echo '</table>';
        echo '<form method="post" style="margin-top:20px;">
                <button type="submit" name="show_add_form">Dodaj nową podstronę</button>
              </form>';
    } catch (Exception $e) {
        echo "Błąd: " . $e->getMessage();
    }
}

// Funkcja EdytujPodstrone
function EdytujPodstrone($id) {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_edit'])) {
        try {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $status = isset($_POST['status']) ? 1 : 0;

            $query = "UPDATE page_list SET page_title = :title, page_content = :content, status = :status WHERE id = :id LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute([':title' => $title, ':content' => $content, ':status' => $status, ':id' => $id]);

            echo '<p>Podstrona została zaktualizowana.</p>';
            header("Location: admin.php");
            exit;
        } catch (Exception $e) {
            echo '<p>Błąd podczas zapisywania zmian: ' . $e->getMessage() . '</p>';
        }
    }

    $query = "SELECT * FROM page_list WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    $page = $stmt->fetch(PDO::FETCH_ASSOC);

    echo '<form method="post">';
    echo '<label>Tytuł: <input type="text" name="title" value="' . htmlspecialchars($page['page_title']) . '"></label><br>';
    echo '<label>Treść: <textarea name="content">' . htmlspecialchars($page['page_content']) . '</textarea></label><br>';
    echo '<label>Aktywna: <input type="checkbox" name="status"' . ($page['status'] ? ' checked' : '') . '></label><br>';
    echo '<input type="hidden" name="edit_id" value="' . $id . '">';
    echo '<button type="submit" name="save_edit">Zapisz</button>';
    echo '</form>';
}

// Funkcja DodajNowaPodstrone
function DodajNowaPodstrone() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_page'])) {
        try {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $status = isset($_POST['status']) ? 1 : 0;

            $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (:title, :content, :status)";
            $stmt = $conn->prepare($query);
            $stmt->execute([':title' => $title, ':content' => $content, ':status' => $status]);

            echo '<p>Podstrona została dodana.</p>';
            header("Location: admin.php");
            exit;
        } catch (Exception $e) {
            echo '<p>Błąd podczas dodawania podstrony: ' . $e->getMessage() . '</p>';
        }
    }

    echo '<form method="post">';
    echo '<label>Tytuł: <input type="text" name="title"></label><br>';
    echo '<label>Treść: <textarea name="content"></textarea></label><br>';
    echo '<label>Aktywna: <input type="checkbox" name="status"></label><br>';
    echo '<button type="submit" name="add_page">Dodaj</button>';
    echo '</form>';
}

// Funkcja UsunPodstrone
function UsunPodstrone($id) {
    global $conn;

    try {
        $query = "DELETE FROM page_list WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);

        echo '<p>Podstrona została usunięta.</p>';
        header("Location: admin.php");
        exit;
    } catch (Exception $e) {
        echo '<p>Błąd podczas usuwania podstrony: ' . $e->getMessage() . '</p>';
    }
}

// Logika zarządzania akcjami
if (isset($_POST['edit'])) {
    EdytujPodstrone($_POST['edit']);
} elseif (isset($_POST['delete'])) {
    UsunPodstrone($_POST['delete']);
} elseif (isset($_POST['show_add_form'])) {
    echo '<h2>Dodaj nową podstronę</h2>';
    DodajNowaPodstrone();
} elseif (isset($_POST['add_page'])) {
    DodajNowaPodstrone();
} elseif (isset($_POST['save_edit'])) {
    if (isset($_POST['edit_id'])) {
        EdytujPodstrone($_POST['edit_id']);
    }
} else {
    ListaPodstron();
}
echo '<a href="../index.php?id=1" style="margin-left: 10px;">Powrót na stronę główną</a'
?>