<?php
// Database configuration
$host = 'localhost';
$dbname = 'fluxterra';
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Set charset
    $pdo->exec("SET NAMES utf8mb4");
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Helper function to get user by ID
function getUserById($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

// Helper function to get user by email
function getUserByEmail($pdo, $email) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

// Helper function to check if user is admin
function isAdmin($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    return $user && $user['role'] === 'admin';
}

// Helper function to get all active sims
function getActiveSims($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM sims WHERE is_active = 1 ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll();
}

// Helper function to get tracks by sim
function getTracksBySim($pdo, $simId) {
    $stmt = $pdo->prepare("SELECT * FROM tracks WHERE sim_id = ? AND is_active = 1 ORDER BY name");
    $stmt->execute([$simId]);
    return $stmt->fetchAll();
}

// Helper function to get vehicle classes by sim
function getVehicleClassesBySim($pdo, $simId) {
    $stmt = $pdo->prepare("SELECT * FROM vehicle_classes WHERE sim_id = ? AND is_active = 1 ORDER BY name");
    $stmt->execute([$simId]);
    return $stmt->fetchAll();
}

// Helper function to get cars by class
function getCarsByClass($pdo, $classId) {
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE class_id = ? AND is_active = 1 ORDER BY name");
    $stmt->execute([$classId]);
    return $stmt->fetchAll();
}

// Helper function to get upcoming events
function getUpcomingEvents($pdo, $limit = 10) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE is_upcoming = 1 AND event_date >= CURDATE() ORDER BY event_date, event_time LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

// Helper function to get leaderboard data
function getLeaderboard($pdo, $sim, $category, $track, $limit = 5) {
    $stmt = $pdo->prepare("
        SELECT u.username, MIN(l.lap_time) as best_time, l.recorded_date
        FROM lap_times l
        JOIN users u ON l.user_id = u.id
        WHERE l.sim = ? AND l.category = ? AND l.track = ?
        GROUP BY l.user_id, u.username
        ORDER BY best_time ASC
        LIMIT ?
    ");
    $stmt->execute([$sim, $category, $track, $limit]);
    return $stmt->fetchAll();
}

// Helper function to get user's rank in leaderboard
function getUserRank($pdo, $userId, $sim, $category, $track) {
    $stmt = $pdo->prepare("
        SELECT 
            u.username,
            l.lap_time as best_time,
            l.recorded_date,
            (SELECT COUNT(*) + 1 
             FROM lap_times l2 
             WHERE l2.sim = l.sim 
             AND l2.category = l.category 
             AND l2.track = l.track 
             AND l2.lap_time < l.lap_time) as rank
        FROM lap_times l
        JOIN users u ON l.user_id = u.id
        WHERE l.user_id = ? AND l.sim = ? AND l.category = ? AND l.track = ?
    ");
    $stmt->execute([$userId, $sim, $category, $track]);
    return $stmt->fetch();
}

// Helper function to get context around user's rank
function getUserContext($pdo, $userId, $sim, $category, $track) {
    $userRank = getUserRank($pdo, $userId, $sim, $category, $track);
    if (!$userRank) return null;
    
    $rank = $userRank['rank'];
    $context = ['user' => $userRank];
    
    // Get person before (rank-1)
    if ($rank > 1) {
        $stmt = $pdo->prepare("
            SELECT u.username, l.lap_time as best_time
            FROM lap_times l
            JOIN users u ON l.user_id = u.id
            WHERE l.sim = ? AND l.category = ? AND l.track = ?
            ORDER BY l.lap_time ASC
            LIMIT 1 OFFSET ?
        ");
        $stmt->execute([$sim, $category, $track, $rank - 2]);
        $context['before'] = $stmt->fetch();
    }
    
    // Get person after (rank+1)
    $stmt = $pdo->prepare("
        SELECT u.username, l.lap_time as best_time
        FROM lap_times l
        JOIN users u ON l.user_id = u.id
        WHERE l.sim = ? AND l.category = ? AND l.track = ?
        ORDER BY l.lap_time ASC
        LIMIT 1 OFFSET ?
    ");
    $stmt->execute([$sim, $category, $track, $rank]);
    $context['after'] = $stmt->fetch();
    
    return $context;
}
?>