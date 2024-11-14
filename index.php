<?php
require 'db.php'; // Import połączenia do bazy danych

// Sprawdzenie połączenia z bazą danych
if (!$conn) {
    echo "<p>Błąd połączenia z bazą danych. Proszę spróbować ponownie później.</p>";
    exit();
}

// Pobieranie produktów z bazy
try {
    $stmt = $conn->query("SELECT id, name, description, price, category FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Błąd zapytania: " . $e->getMessage();
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
                    Cena: <?php echo number_format($product['price'], 2); ?> PLN<br>
                    Kategoria: <?php echo htmlspecialchars($product['category']); ?><br>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Brak produktów.</li>
        <?php endif; ?>
    </ul>
</body>
</html>
