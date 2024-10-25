<?php
 
// parametry polaczenia
 
$serverName = getenv('DB_SERVER');
$database = getenv('DB_NAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
 
// polaczenie z baza
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PODEXception $e) {
    die("Blad polaczenia z baza danych: " . $e->getMessage());
}
 
?>