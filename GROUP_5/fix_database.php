<?php
// Fix database - Run this once to update the password column size
require_once __DIR__ . '/INCLUDES/db_connection.php';

try {
    $pdo = getDBConnection();
    
    // Alter the password column to be larger
    $stmt = $pdo->exec("ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL");
    
    echo "Database updated successfully! Password column is now VARCHAR(255).";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

