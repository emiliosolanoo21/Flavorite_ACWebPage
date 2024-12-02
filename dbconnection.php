<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=flavorite", "root", "Solano2024MDB");
    // Set the encoding to UTF-8 to avoid issues with special characters
    $pdo->exec("SET NAMES 'utf8'");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
