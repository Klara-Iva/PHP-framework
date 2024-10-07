<?php

$dsn = 'mysql:host=localhost;dbname=php-frameworkDB';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $usersTableExists = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount() > 0;
    $productsTableExists = $pdo->query("SHOW TABLES LIKE 'products'")->rowCount() > 0;

    if (!$usersTableExists) {
        $createUsersTable = "
        CREATE TABLE IF NOT EXISTS users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100),
            last_name VARCHAR(100),
            birthday DATE DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";
        $pdo->exec($createUsersTable);
        echo "Table 'users' created successfully." . PHP_EOL;
    } else {
        echo "Table 'users' already exists." . PHP_EOL;
    }

    if (!$productsTableExists) {
        $createProductsTable = "
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            description TEXT,
            price DECIMAL(10, 2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";
        $pdo->exec($createProductsTable);
        echo "Table 'products' created successfully." . PHP_EOL;
    } else {
        echo "Table 'products' already exists." . PHP_EOL;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();

}