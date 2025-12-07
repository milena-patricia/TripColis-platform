<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS tripcolis_db 
            CHARACTER SET utf8mb4 
            COLLATE utf8mb4_unicode_ci";
    $conn->exec($sql);
    
    echo "Base de données 'tripcolis_db' créée avec succès!\n";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>