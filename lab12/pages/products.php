<?php
include('../includes/auth.php');
check_login();
include('../includes/db_connect.php');

// Obsługa dodawania produktu
if (isset($_POST['add_product'])) {
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $cena_netto = $_POST['cena_netto'];
    $vat = $_POST['vat'];
    $ilosc = $_POST['ilosc'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];

    // Przechowywanie zdjęcia (link lub BLOB)
    if (isset($_FILES['zdjecie'])) {
        $zdjecie = $_FILES['zdjecie']['name'];
        // Możesz dodać kod do zapisu zdjęcia na serwerze, np. w folderze images
    } else {
        $zdjecie = 'default_image.jpg'; // Domyślny obrazek
    }

    $sql = "INSERT INTO products (tytul, opis, cena_netto, vat, ilosc, status, kategoria, gabaryt, zdjecie) 
            VALUES ('$tytul', '$opis', '$cena_netto', '$vat', '$ilosc', 1, '$kategoria', '$gabaryt', '$zdjecie')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Produkt został dodany!";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Pobieranie produktów z bazy
$products = $conn->query("SELECT * FROM products");

// Pobieranie kategorii (w tym podkategorii)
function get_categories($parent_id = 0, $level = 0) {
    global $conn;
    $categories = $conn->query("SELECT * FROM categories WHERE matka = $parent_id");
    
    while ($row = $categories->fetch_assoc()) {
        echo str_repeat('&nbsp;', $level * 4) . "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
        // Rekurencyjnie wyświetlamy podkategorie
        get_categories($row['id'], $level + 1);
    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj Produktami</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Zarządzaj Produktami</h1>

        <!-- Formularz dodawania produktu -->
        <form method="POST" action="products.php" enctype="multipart/form-data">
            <input type="text" name="tytul" placeholder="Tytuł produktu" required>
            <textarea name="opis" placeholder="Opis produktu" required></textarea>
            <input type="number" name="cena_netto" placeholder="Cena netto" required>
            <input type="number" name="vat" placeholder="Stawka VAT" required>
            <input type="number" name="ilosc" placeholder="Ilość" required>
            
            <select name="kategoria" required>
                <option value="">Wybierz kategorię</option>
                <?php
                // Wyświetlanie kategorii głównych oraz podkategorii
                get_categories();
                ?>
            </select>

            <input type="text" name="gabaryt" placeholder="Gabaryt produktu" required>
            <input type="file" name="zdjecie" accept="image/*">
            <button type="submit" name="add_product">Dodaj Produkt</button>
        </form>

        <h2>Produkty</h2>
        <table>
            <tr>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Ilość</th>
                <th>Status</th>
                <th>Kategoria</th>
                <th>Gabaryt</th>
                <th>Zdjęcie</th>
                <th>Akcje</th>
            </tr>
            <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['tytul']; ?></td>
                    <td><?php echo $row['opis']; ?></td>
                    <td><?php echo $row['cena_netto']; ?></td>
                    <td><?php echo $row['vat']; ?></td>
                    <td><?php echo $row['ilosc']; ?></td>
                    <td><?php echo $row['status'] == 1 ? 'Aktywny' : 'Nieaktywny'; ?></td>
                    <td>
                        <?php
                        // Pobierz nazwę kategorii
                        $category_result = $conn->query("SELECT nazwa FROM categories WHERE id = " . $row['kategoria']);
                        $category = $category_result->fetch_assoc();
                        echo $category['nazwa'];
                        ?>
                    </td>
                    <td><?php echo $row['gabaryt']; ?></td>
                    <td><img src="images/<?php echo $row['zdjecie']; ?>" alt="Zdjęcie" width="50"></td>
                    <td><a href="products.php?edit=<?php echo $row['id']; ?>">Edytuj</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>
</body>
</html>
