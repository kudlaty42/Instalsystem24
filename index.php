<?php
// Sprawdzenie, czy plik db.php istnieje
if (!file_exists('db.php')) {
    echo "<p>Plik konfiguracji bazy danych nie został odnaleziony.</p>";
    exit();
}
require 'db.php';

// Sprawdzenie połączenia z bazą danych
if (!isset($conn)) {
    echo "<p>Nie udało się nawiązać połączenia z bazą danych.</p>";
    exit();
}

// Pobieranie produktów z bazy
try {
    $stmt = $conn->query("SELECT id, name, description, price, category FROM products ORDER BY name ASC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Błąd zapytania: " . htmlspecialchars($e->getMessage());
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

    <h2>Lista produktów:</h2>
    <ul>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <li>
                    <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                    Opis: <?php echo htmlspecialchars($product['description']); ?><br>
                    Cena: <?php echo number_format((float)$product['price'], 2); ?> PLN<br>
                    Kategoria: <?php echo htmlspecialchars($product['category']); ?><br>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Brak produktów.</li>
        <?php endif; ?>
    </ul>
</body>
</html>