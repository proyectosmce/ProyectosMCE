<?php
require_once '../includes/config.php';
require_once '../includes/testimonial-helpers.php';

header('Content-Type: application/json');

ensureTestimonialsSchema($conn);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method']);
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'id']);
    exit;
}

// Solo incrementar likes en testimonios aprobados
$stmt = $conn->prepare('UPDATE testimonios SET likes = likes + 1 WHERE id = ? AND aprobado = 1');
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows < 1) {
    $stmt->close();
    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'notfound']);
    exit;
}
$stmt->close();

$likes = 0;
$res = $conn->prepare('SELECT likes FROM testimonios WHERE id = ? LIMIT 1');
$res->bind_param('i', $id);
$res->execute();
$res->bind_result($likes);
$res->fetch();
$res->close();

echo json_encode(['ok' => true, 'likes' => (int) $likes]);
exit;
