<?php

require 'db.php'; // importujemy polaczenie do bazy danych
 
// pobieranie produktow z bazy

try {
    $stmt = $conn->query("SELECT id, name, description, price, category FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { // Poprawiona nazwa wyjątku
    echo "Blad zapytania: " . htmlspecialchars($e->getMessage());
    exit();
}

?>
 
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sklep instalacyjny</title>
</head>
<body>
<h1>Sklep instalacyjny</h1>
 
<h2>Lista produktów:</h2>
<ul>
<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <li>
            <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
            Opis: <?php echo htmlspecialchars($product['description']); ?><br>
            Cena: <?php echo number_format(htmlspecialchars($product['price']), 2); ?> PLN<br>
            Kategoria: <?php echo htmlspecialchars($product['category']); ?><br>
        </li>
    <?php endforeach; ?>
<?php else: ?>
    <li>Brak produktów.</li>
<?php endif; ?>
</ul>
</body>
</html>
