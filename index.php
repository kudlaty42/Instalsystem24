<?php
// Ustawienia połączenia z bazą danych
$serverName = getenv('DB_SERVER');
$database = getenv('DB_NAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

// Połączenie z bazą danych
try {
    $conn = new PDO(
        "sqlsrv:server=$serverName;Database=$database;Encrypt=yes",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo "<p>Nie można połączyć z bazą danych. Szczegóły: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}

// Obsługa formularzy
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Dodawanie produktu
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, category) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $category]);
    } elseif (isset($_POST['update_product'])) {
        // Aktualizacja produktu
        $id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $category, $id]);
    } elseif (isset($_POST['delete_product'])) {
        // Usuwanie produktu
        $id = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['add_category'])) {
        // Dodawanie kategorii (logika tylko w pamięci)
        $new_category = $_POST['new_category'];
        $categories[] = $new_category;
    }
}

// Pobieranie produktów z bazy danych
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Pobieranie unikalnych kategorii
$categories = $conn->query("SELECT DISTINCT category FROM products")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Instalacyjny</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Sklep Instalacyjny</h1>
    </header>
    <main>
        <div class="left-panel">
            <h2>Lista produktów:</h2>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                        Opis: <?php echo htmlspecialchars($product['description']); ?><br>
                        Cena: <?php echo number_format($product['price'], 2); ?> PLN<br>
                        Kategoria: <?php echo htmlspecialchars($product['category']); ?><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="right-panel">
            <h2>Dodaj / Zaktualizuj produkt:</h2>
            <form method="POST">
                <select name="product_id">
                    <option value="">Wybierz produkt do edycji...</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['id']; ?>">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="name" placeholder="Nazwa produktu" required>
                <textarea name="description" placeholder="Opis produktu" required></textarea>
                <input type="number" step="0.01" name="price" placeholder="Cena produktu" required>
                <select name="category" required>
                    <option value="">Wybierz kategorię...</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>">
                            <?php echo htmlspecialchars($category); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="add_product">Dodaj produkt</button>
                <button type="submit" name="update_product">Zaktualizuj produkt</button>
                <button type="submit" name="delete_product">Usuń produkt</button>
            </form>

            <h2>Dodaj kategorię:</h2>
            <form method="POST">
                <input type="text" name="new_category" placeholder="Nazwa kategorii" required>
                <button type="submit" name="add_category">Dodaj kategorię</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sklep Instalacyjny. P&R Dev Team®</p>
    </footer>
</body>
</html>

