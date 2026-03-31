<?php
require_once __DIR__ . '/../includes/header_functions.php'; // Para app_url y otros
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = isset($_POST['project']) ? $conn->real_escape_string($_POST['project']) : 'General';
    $url = isset($_POST['url']) ? $conn->real_escape_string($_POST['url']) : 'Unknown';

    $sql = "INSERT INTO activity_leads (project_name, page_url) VALUES ('$project', '$url')";
    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}
?>
