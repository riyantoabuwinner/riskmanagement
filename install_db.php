<?php
try {
    $pdo = new PDO('mysql:host=localhost;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS riskmanagement_v2");
    echo "Database created successfully\n";
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
