<?php
// Login API - Handles authentication
header('Content-Type: application/json');
require_once __DIR__ . '/../INCLUDES/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields']);
        exit;
    }

    try {
        $pdo = getDBConnection();
        
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Debug: check if user exists
        if (!$user) {
            error_log("User not found: $username");
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit;
        }
        
        error_log("User found: " . $user['username'] . ", Password hash: " . $user['password']);
        
        // Verify password - accepts both hashed and plain text passwords
        $passwordMatch = password_verify($password, $user['password']);
        $plainMatch = ($password === $user['password']);
        error_log("password_verify result: " . ($passwordMatch ? 'true' : 'false') . ", plain match: " . ($plainMatch ? 'true' : 'false'));
        
        if ($user && ($passwordMatch || $plainMatch)) {
            // Start session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            echo json_encode(['success' => true, 'message' => 'Login successful!']);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Invalid username or password',
                'debug' => [
                    'username' => $username,
                    'stored_hash' => $user['password'],
                    'password_verify' => $passwordMatch ? 'true' : 'false',
                    'plain_match' => $plainMatch ? 'true' : 'false'
                ]
            ]);
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

