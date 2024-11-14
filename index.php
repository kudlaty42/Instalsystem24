<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
require 'db.php'; // Import połączenia do bazy danych

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    try {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, category) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $category]);
        // Przekierowanie z powrotem na stronę główną
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Błąd przy dodawaniu produktu: " . $e->getMessage();
    }
}
?>

<h1>Sklep Instalacyjny</h1>
<h2>Produkty:</h2>
<ul>
<?php
// Przykładowa definicja zmiennej $products
$products = [
    ['name' => 'Produkt 1', 'description' => 'Opis 1', 'price' => 10.00, 'category' => 'Kategoria 1'],
    ['name' => 'Produkt 2', 'description' => 'Opis 2', 'price' => 20.00, 'category' => 'Kategoria 2']
];

foreach ($products as $product): ?>
<li>
<strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                Opis: <?php echo htmlspecialchars($product['description']); ?><br>
                Cena: <?php echo number_format($product['price'], 2); ?> PLN<br>
                Kategoria: <?php echo htmlspecialchars($product['category']); ?><br>
</li>
<?php endforeach; ?>
</ul>

<h2>Dodaj nowy produkt:</h2>
<form action="add_product.php" method="POST">
<label for="name">Nazwa produktu:</label>
<input type="text" name="name" required><br>
<label for="description">Opis:</label>
<textarea name="description" required></textarea><br>
<label for="price">Cena:</label>
<input type="number" name="price" step="0.01" required><br>
<label for="category">Kategoria:</label>
<input type="text" name="category" required><br>
<button type="submit">Dodaj produkt</button>
</form>
</body>
</html>
