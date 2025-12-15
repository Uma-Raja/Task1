<?php
ob_start(); // Prevent any accidental HTML/warnings from breaking JSON
header('Content-Type: application/json');
require_once 'config.php';

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Read POST data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$phone = trim($_POST['phone'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$address = trim($_POST['address'] ?? '');

// Basic validation
if (!$name || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Name, email, and password are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

try {
    // Check if email already exists in MySQL
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Email already registered']);
        exit;
    }

    // Insert into MySQL
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $insert = $pdo->prepare("
        INSERT INTO users (name, email, password, phone, dob, address)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $insert->execute([
        $name,
        $email,
        $hash,
        $phone ?: null,
        $dob ?: null,
        $address ?: null
    ]);

    $mysqlUserId = (int) $pdo->lastInsertId();

    // Insert into MongoDB
    if (!$profilesCollection) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'MongoDB connection not available'
    ]);
    exit;
}

try {
    $now = new MongoDB\BSON\UTCDateTime((new DateTime())->getTimestamp() * 1000);

    $profilesCollection->insertOne([
        'mysql_user_id' => $mysqlUserId,
        'name'          => $name,
        'email'         => $email,
        'phone'         => $phone ?: null,
        'dob'           => $dob ?: null,
        'address'       => $address ?: null,
        'created_at'    => $now,
        'updated_at'    => $now
    ]);
} catch (Throwable $mongoError) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'MongoDB insert failed',
        'error'   => $mongoError->getMessage()
    ]);
    exit;
}


} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    exit;
}
