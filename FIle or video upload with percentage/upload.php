<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Request must be POST']);
    exit;
}

if (!isset($_FILES['video'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded', 'debug' => $_FILES]);
    exit;
}

// Check for upload errors
if ($_FILES['video']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Upload error', 'error_code' => $_FILES['video']['error']]);
    exit;
}

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$filePath = $uploadDir . basename($_FILES['video']['name']);

if (move_uploaded_file($_FILES['video']['tmp_name'], $filePath)) {
    echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'File move failed',
        'debug' => [
            'tmp_name' => $_FILES['video']['tmp_name'],
            'destination' => $filePath,
            'is_uploaded' => is_uploaded_file($_FILES['video']['tmp_name'])
        ]
    ]);
}
?>