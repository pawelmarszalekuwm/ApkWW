<?php
session_start();
include('../includes/db_connect.php');

// Funkcja dodawania produktu do koszyka
function addToCart($id, $name, $price, $vat, $quantity) {
    global $conn;

    // Pobierz dostępność produktu z bazy danych
    $query = "SELECT ilosc FROM products WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $available_quantity = $product['ilosc'];

        // Sprawdź, czy żądana ilość jest dostępna
        if (isset($_SESSION['cart'][$id])) {
            $current_quantity = $_SESSION['cart'][$id]['quantity'];
        } else {
            $current_quantity = 0;
        }

        if ($current_quantity + $quantity > $available_quantity) {
            echo "<p style='color: red;'>Brak wystarczającej ilości produktu w magazynie.</p>";
            return;
        }

        // Jeśli produkt już istnieje w koszyku, zwiększ jego ilość
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            // Dodaj nowy produkt do koszyka
            $_SESSION['cart'][$id] = [
                'name' => $name,
                'price' => $price,
                'vat' => $vat,
                'quantity' => $quantity
            ];
        }
    } else {
        echo "<p style='color: red;'>Produkt nie został znaleziony.</p>";
    }
}

// Funkcja usuwania produktu z koszyka
function removeFromCart($id) {
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

// Funkcja aktualizacji ilości w koszyku
function updateCart($id, $quantity) {
    global $conn;

    // Pobierz dostępność produktu z bazy danych
    $query = "SELECT ilosc FROM products WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $available_quantity = $product['ilosc'];

        // Sprawdź, czy żądana ilość jest dostępna
        if ($quantity > $available_quantity) {
            echo "<p style='color: red;'>Brak wystarczającej ilości produktu w magazynie.</p>";
            return;
        }

        // Zaktualizuj ilość w koszyku
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    } else {
        echo "<p style='color: red;'>Produkt nie został znaleziony.</p>";
    }
}

// Funkcja wyświetlania koszyka
function showCart() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Twój koszyk jest pusty.</p>";
        return;
    }

    echo "<table border='1'>";
    echo "<tr><th>Produkt</th><th>Cena netto</th><th>VAT</th><th>Cena brutto</th><th>Ilość</th><th>Razem</th><th>Akcje</th></tr>";

    $total = 0;
    foreach ($_SESSION['cart'] as $id => $item) {
        $brutto = $item['price'] + ($item['price'] * ($item['vat'] / 100));
        $subtotal = $brutto * $item['quantity'];
        $total += $subtotal;

        echo "<tr>
                <td>{$item['name']}</td>
                <td>{$item['price']} PLN</td>
                <td>{$item['vat']}%</td>
                <td>{$brutto} PLN</td>
                <td>
                    <form method='POST' action='cart.php'>
                        <input type='hidden' name='id' value='{$id}'>
                        <input type='number' name='quantity' value='{$item['quantity']}' min='1'>
                        <button type='submit' name='update'>Aktualizuj</button>
                    </form>
                </td>
                <td>{$subtotal} PLN</td>
                <td>
                    <a href='cart.php?action=remove&id={$id}'>Usuń</a>
                </td>
              </tr>";
    }

    echo "<tr>
            <td colspan='5'>Razem:</td>
            <td colspan='2'><strong>{$total} PLN</strong></td>
          </tr>";
    echo "</table>";
}

// Obsługa akcji koszyka
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            // Dodaj produkt do koszyka (przykładowe dane)
            $id = intval($_GET['id']);
            $name = $_GET['name'];
            $price = floatval($_GET['price']);
            $vat = floatval($_GET['vat']);
            $quantity = intval($_GET['quantity']);
            addToCart($id, $name, $price, $vat, $quantity);
            break;

        case 'remove':
            // Usuń produkt z koszyka
            $id = intval($_GET['id']);
            removeFromCart($id);
            break;
    }
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);
    updateCart($id, $quantity);
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
</head>
<body>
    <h1>Koszyk</h1>
    <?php showCart(); ?>
    <a href="shop.php">Wróć do sklepu</a>
</body>
</html>
