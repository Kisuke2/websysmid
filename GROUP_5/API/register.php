<?php
// Registration API - Handles new user registration
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

// Custom error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $errstr]);
    exit;
});

// Custom exception handler
set_exception_handler(function($exception) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $exception->getMessage()]);
    exit;
});

require_once __DIR__ . '/../INCLUDES/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields']);
        exit;
    }

    // Validate username length
    if (strlen($username) < 3) {
        echo json_encode(['success' => false, 'message' => 'Username must be at least 3 characters']);
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
        exit;
    }

    // Validate password length
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        exit;
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }

    try {
        $pdo = getDBConnection();
        
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Username already taken']);
            exit;
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already registered']);
            exit;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);

        echo json_encode(['success' => true, 'message' => 'Registration successful! You can now login.']);
    } catch (PDOException $e) {
        error_log("Registration Error: " . $e->getMessage());
        $errorMsg = $e->getMessage();
        // Check for specific error messages
        if (strpos($errorMsg, 'Duplicate entry') !== false) {
            if (strpos($errorMsg, 'username') !== false) {
                echo json_encode(['success' => false, 'message' => 'Username already exists']);
            } elseif (strpos($errorMsg, 'email') !== false) {
                echo json_encode(['success' => false, 'message' => 'Email already exists']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Username or email already exists']);
            }
        } else {
            // Show actual error for debugging
            echo json_encode(['success' => false, 'message' => 'Error: ' . $errorMsg]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
