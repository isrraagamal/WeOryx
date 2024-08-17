<?php

define("DATABASE_HOST", "localhost");
define("DATABASE_NAME", "espoir");
define("DATABASE_USER", "root");
define("DATABASE_PASSWORD", "");

try {
    $dsn = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME;
    $pdo = new PDO($dsn, DATABASE_USER, DATABASE_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    echo "Database connection error: " . $e->getMessage();
}

?>
