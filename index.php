<?php
// Ustawienia połączenia z bazą danych
$serverName = getenv('DB_SERVER');
$database = getenv('DB_NAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

// Połączenie z bazą danych
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<p>Nie można połączyć z bazą danych. Szczegóły: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}

// Pobieranie produktów z bazy danych
$products = [];
try {
    $stmt = $conn->query("SELECT id, name, description, price, category FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Błąd podczas pobierania danych: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Instalacyjny</title>
</head>
<body>
    <h1>Sklep Instalacyjny</h1>

    <?php if (!empty($products)): ?>
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
    <?php else: ?>
        <p>Brak dostępnych produktów.</p>
    <?php endif; ?>
</body>
</html>
