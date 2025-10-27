<?php
// Handle POST contact submissions
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}
// Get JSON body
$body = file_get_contents('php://input');
$data = json_decode($body, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}
// Add date field
$data['date'] = date('c'); // ISO 8601
// Path to contacts.json relative to this script
$contactsFile = __DIR__ . '/../contacts.json';
$contacts = [];
if (file_exists($contactsFile)) {
    $raw = file_get_contents($contactsFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
        $contacts = $decoded;
    }
}
$contacts[] = $data;
file_put_contents($contactsFile, json_encode($contacts, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
echo json_encode(['success' => true]);
?>
