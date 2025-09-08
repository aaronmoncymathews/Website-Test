<?php
session_start();
require_once 'db.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Check if user is admin
function requireAdmin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
    
    if (!isAdmin($pdo, $_SESSION['user_id'])) {
        header('Location: /index.php');
        exit();
    }
}

// Check if user is logged in (redirect to login if not)
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

// Get current user data
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return getUserById($pdo, $_SESSION['user_id']);
}

// Login function
function login($email, $password) {
    global $pdo;
    
    $user = getUserByEmail($pdo, $email);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

// Register function
function register($email, $username, $password) {
    global $pdo;
    
    // Check if email already exists
    if (getUserByEmail($pdo, $email)) {
        return ['success' => false, 'message' => 'Email already exists'];
    }
    
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Username already exists'];
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$email, $username, $hashedPassword])) {
        return ['success' => true, 'message' => 'Registration successful'];
    }
    
    return ['success' => false, 'message' => 'Registration failed'];
}

// Logout function
function logout() {
    session_destroy();
    header('Location: /index.php');
    exit();
}

// Sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate password strength
function validatePassword($password) {
    return strlen($password) >= 8;
}
?>