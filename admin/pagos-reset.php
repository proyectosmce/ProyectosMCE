<?php
require_once '../includes/config.php';
require_once '../includes/admin-helpers.php';
require_once '../includes/project-helpers.php';
require_once '../includes/payment-helpers.php';
require_once '../includes/testimonial-helpers.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$redirect = 'pagos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $redirect);
    exit;
}

if (!admin_validate_csrf($_POST['csrf_token'] ?? null)) {
    header('Location: ' . admin_build_url($redirect, ['msg' => 'reset_error']));
    exit;
}

$adminId = (int) ($_SESSION['admin_id'] ?? 0);
$adminPassword = (string) ($_POST['admin_password'] ?? '');

if ($adminId <= 0 || $adminPassword === '') {
    header('Location: ' . admin_build_url($redirect, ['msg' => 'reset_error']));
    exit;
}

// Verificar contraseña actual del admin
$stmt = $conn->prepare("SELECT password_hash FROM usuarios WHERE id = ? LIMIT 1");
if (!$stmt) {
    header('Location: ' . admin_build_url($redirect, ['msg' => 'reset_error']));
    exit;
}
$stmt->bind_param('i', $adminId);
$stmt->execute();
$res = $stmt->get_result();
$row = $res ? $res->fetch_assoc() : null;
$stmt->close();

if (!$row || !password_verify($adminPassword, $row['password_hash'])) {
    header('Location: ' . admin_build_url($redirect, ['msg' => 'reset_error']));
    exit;
}

// Helper: verificar existencia de tabla
$table_exists = function (mysqli $conn, string $table): bool {
    $safe = $conn->real_escape_string($table);
    $check = $conn->query("SHOW TABLES LIKE '{$safe}'");
    return $check instanceof mysqli_result && $check->num_rows > 0;
};

$tablesToTruncate = [
    'proyecto_pagos',
    'abonos_historial',
    'citas',
    'mensajes',
];

$conn->query('SET FOREIGN_KEY_CHECKS=0');
foreach ($tablesToTruncate as $table) {
    if ($table_exists($conn, $table)) {
        $conn->query("TRUNCATE TABLE {$table}");
    }
}
$conn->query('SET FOREIGN_KEY_CHECKS=1');

admin_log_action($conn, 'delete', 'system', $adminId, 'Reset general de datos (truncate tablas)');

header('Location: ' . admin_build_url($redirect, ['msg' => 'reset_ok']));
exit;
?>
