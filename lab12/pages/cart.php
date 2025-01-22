<?php
include('includes/db_connect.php');

// Retrieve selected category and sorting option
$category_id = isset($_GET['category']) ? intval($_GET['category']) : 0; // Default: all categories
$order_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'tytul'; // Default: sort by name

// Function to get all category IDs, including subcategories
function getAllCategoryIds($parent_id, $conn) {
    $ids = [$parent_id]; // Include the parent category
    $result = $conn->query("SELECT id FROM categories WHERE matka = $parent_id");
    while ($row = $result->fetch_assoc()) {
        $ids = array_merge($ids, getAllCategoryIds($row['id'], $conn));
    }
    return $ids;
}

// SQL Query for products
if ($category_id > 0) {
    $category_ids = getAllCategoryIds($category_id, $conn);
    $category_ids_string = implode(",", $category_ids);
    $sql = "SELECT * FROM products WHERE kategoria IN ($category_ids_string)";
} else {
    $sql = "SELECT * FROM products";
}
$sql .= " ORDER BY $order_by";

// Execute query
$result = $conn->query($sql);

// Get all categories for filter
$categories_result = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Internetowy</title>
    <link rel="stylesheet" href="css/styleshop.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sklep Internetowy</h1>
            <nav>
                <a href="login.php" class="login-link">Zaloguj się</a>
            </nav>
        </header>

        <!-- Filter Form -->
        <form method="GET" action="shop.php">
            <label for="category">Filtruj według kategorii:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="0">Wszystkie</option>
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $category_id) ? 'selected' : ''; ?>>
                        <?php echo $category['nazwa']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="sort_by">Sortuj według:</label>
            <select name="sort_by" id="sort_by" onchange="this.form.submit()">
                <option value="tytul" <?php echo ($order_by == 'tytul') ? 'selected' : ''; ?>>Nazwa</option>
                <option value="cena_netto" <?php echo ($order_by == 'cena_netto') ? 'selected' : ''; ?>>Cena</option>
            </select>
        </form>

        <!-- Product Listing -->
        <div class="products">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="images/<?php echo $product['zdjecie']; ?>" alt="Zdjęcie produktu" width="150">
                        <h3><a href="product_page.php?id=<?php echo $product['id']; ?>"><?php echo $product['tytul']; ?></a></h3>
                        <p><?php echo $product['opis']; ?></p>
                        <p><strong>Cena netto: <?php echo $product['cena_netto']; ?> PLN</strong></p>
                        <a href="cart.php?action=add&id=<?php echo $product['id']; ?>&name=<?php echo urlencode($product['tytul']); ?>&price=<?php echo $product['cena_netto']; ?>&vat=<?php echo $product['vat']; ?>&quantity=1">
                            Dodaj do koszyka
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Brak produktów do wyświetlenia.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
