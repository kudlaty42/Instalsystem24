<?php
require 'db.php';
try {
    $stmt = $conn->query("Select id, name, description, price, category FROM products")};
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

catch (PODEXception $e) {
    echo "Blad zapytania: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep instalacyjny</title>

    <head>
        <body>
            <h1>Sklep instalacyjny</h1>
</body>
</html>