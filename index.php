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
