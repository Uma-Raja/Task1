<?php
ob_start();
require_once __DIR__ . '/config.php';

// Get Authorization header (case-insensitive)
$headers = array_change_key_case(getallheaders(), CASE_LOWER);
$auth = $headers['authorization'] ?? '';

if (preg_match('/Bearer\s+(\S+)/', $auth, $matches)) {
    $token = $matches[1];

    // Delete token from Redis
    if ($redis) {
        $redis->del("auth_token:$token");
    }
}

// Check if request expects JSON (AJAX)
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
    exit;
}

// Otherwise, redirect to login page
header('Location: ../html/login.html');
exit;

