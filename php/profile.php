<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

ob_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';

// ---------- CHECK SERVICES ----------
if (!$redis) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Redis not available']);
    exit;
}

if (!$profilesCollection) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'MongoDB not available']);
    exit;
}

// ---------- GET AUTH HEADER (case-safe) ----------
$headers = array_change_key_case(getallheaders(), CASE_LOWER);
$auth = $headers['authorization'] ?? '';

if (!preg_match('/Bearer\s+(\S+)/', $auth, $matches)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$token = $matches[1];

// ---------- VALIDATE TOKEN ----------
$userId = $redis->get("auth_token:$token");

if (!$userId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
    exit;
}

$userId = (int) $userId;

// ---------- GET PROFILE ----------
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $profile = $profilesCollection->findOne(['mysql_user_id' => $userId]);

        if (!$profile) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Profile not found']);
            exit;
        }

        echo json_encode([
            'success' => true,
            'user' => [
                'name'    => $profile['name'] ?? '',
                'email'   => $profile['email'] ?? '',
                'phone'   => $profile['phone'] ?? '',
                'dob'     => $profile['dob'] ?? '',
                'address' => $profile['address'] ?? ''
            ]
        ]);
        exit;

    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to load profile',
            'error'   => $e->getMessage()
        ]);
        exit;
    }
}


// ---------- UPDATE PROFILE ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $now = new MongoDB\BSON\UTCDateTime((new DateTime())->getTimestamp() * 1000);

        $update = [
            'name'       => trim($_POST['name'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'dob'        => trim($_POST['dob'] ?? ''),
            'address'    => trim($_POST['address'] ?? ''),
            'updated_at' => $now
        ];

        $profilesCollection->updateOne(
            ['mysql_user_id' => $userId],
            ['$set' => $update]
        );

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user'    => [
                'name' => $update['name']
            ]
        ]);
        exit;

    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Profile update failed',
            'error'   => $e->getMessage()
        ]);
        exit;
    }
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
exit;
