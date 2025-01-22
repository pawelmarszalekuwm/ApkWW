<?php
include('../includes/auth.php');
check_login();
include('../includes/db_connect.php');

// Obsługa dodawania kategorii
if (isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $parent = $_POST['parent'];  // ID kategorii nadrzędnej
    $sql = "INSERT INTO categories (nazwa, matka) VALUES ('$name', '$parent')";
    if ($conn->query($sql) === TRUE) {
        echo "Nowa kategoria została dodana!";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Obsługa edycji kategorii
if (isset($_POST['edit_category'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sql = "UPDATE categories SET nazwa = '$name' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Kategoria została zaktualizowana!";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Obsługa usuwania kategorii
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Kategoria została usunięta!";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Pobieranie kategorii z bazy danych
$categories = $conn->query("SELECT * FROM categories");

// Funkcja do generowania drzewa kategorii
function display_categories($parent_id = 0, $level = 0) {
    global $conn;
    // Pobieranie kategorii dla danej kategorii nadrzędnej
    $categories_query = $conn->query("SELECT * FROM categories WHERE matka = $parent_id");

    // Sprawdzamy, czy są kategorie do wyświetlenia
    if ($categories_query->num_rows > 0) {
        // Zaczynamy wyświetlanie kategorii
        while ($row = $categories_query->fetch_assoc()) {
            echo str_repeat('&nbsp;', $level * 4); // Wcięcie dla hierarchii
            echo "<li>" . $row['nazwa'] . " <a href='categories.php?edit=" . $row['id'] . "'>Edytuj</a> | <a href='categories.php?delete=" . $row['id'] . "'>Usuń</a></li>";
            // Rekursywnie wyświetlamy podkategorie
            display_categories($row['id'], $level + 1);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj Kategoriami</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Zarządzaj Kategoriami</h1>

        <!-- Formularz dodawania kategorii -->
        <form method="POST">
            <input type="text" name="name" placeholder="Nazwa kategorii" required>
            <select name="parent">
                <option value="0">Wybierz kategorię nadrzędną</option>
                <?php
                // Pobieramy wszystkie kategorie główne (matka = 0)
                $main_categories = $conn->query("SELECT * FROM categories WHERE matka = 0");
                while ($row = $main_categories->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="add_category">Dodaj Kategorię</button>
        </form>

        <h2>Kategorie</h2>
        <ul>
            <?php
            // Generowanie drzewa kategorii, teraz z przekazaniem argumentów
            display_categories(0, 0);  // Przekazanie wartości domyślnych (parent_id = 0, level = 0)
            ?>
        </ul>
    </div>
</body>
</html>
