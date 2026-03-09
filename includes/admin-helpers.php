<?php

function admin_get_csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['admin_csrf_token']) || !is_string($_SESSION['admin_csrf_token'])) {
        $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['admin_csrf_token'];
}

function admin_validate_csrf(?string $token): bool
{
    if (!is_string($token) || $token === '') {
        return false;
    }

    return hash_equals(admin_get_csrf_token(), $token);
}

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function admin_build_query(array $params): string
{
    $clean = [];

    foreach ($params as $key => $value) {
        if ($value === null || $value === '' || $value === false) {
            continue;
        }

        if ($key === 'page' && (int) $value <= 1) {
            continue;
        }

        $clean[$key] = $value;
    }

    return http_build_query($clean);
}

function admin_build_url(string $path, array $params = []): string
{
    $query = admin_build_query($params);

    return $query !== '' ? $path . '?' . $query : $path;
}

function admin_paginate(int $totalItems, int $perPage, int $currentPage): array
{
    $perPage = max(1, $perPage);
    $totalPages = max(1, (int) ceil($totalItems / $perPage));
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;

    return [
        'per_page' => $perPage,
        'page' => $currentPage,
        'total_items' => $totalItems,
        'total_pages' => $totalPages,
        'offset' => $offset,
        'has_prev' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages,
    ];
}

function admin_send_csv(string $filename, array $headers, array $rows): void
{
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    if ($output === false) {
        exit;
    }

    fwrite($output, "\xEF\xBB\xBF");
    fputcsv($output, $headers);

    foreach ($rows as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}

function admin_normalize_phone(?string $phone): string
{
    $phone = trim((string) $phone);
    return preg_replace('/[^0-9]/', '', $phone) ?? '';
}

function admin_whatsapp_url(?string $phone, string $contactName = ''): ?string
{
    $normalizedPhone = admin_normalize_phone($phone);

    if ($normalizedPhone === '') {
        return null;
    }

    $message = 'Hola';
    if ($contactName !== '') {
        $message .= ' ' . trim($contactName);
    }
    $message .= ', te escribo desde el panel de Proyectos MCE.';

    return 'https://wa.me/' . $normalizedPhone . '?text=' . rawurlencode($message);
}

function admin_log_column_exists(mysqli $conn, string $columnName): bool
{
    $safeColumn = $conn->real_escape_string($columnName);
    $result = $conn->query("SHOW COLUMNS FROM admin_activity_log LIKE '{$safeColumn}'");

    return $result instanceof mysqli_result && $result->num_rows > 0;
}

function ensureAdminActivityLogSchema(mysqli $conn): void
{
    static $ready = false;

    if ($ready) {
        return;
    }

    $conn->query("
        CREATE TABLE IF NOT EXISTS admin_activity_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NULL,
            admin_username VARCHAR(100) NOT NULL,
            action VARCHAR(100) NOT NULL,
            entity_type VARCHAR(100) NOT NULL,
            entity_id INT NULL,
            description TEXT NULL,
            ip_address VARCHAR(45) NULL,
            user_agent VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $missingColumns = [
        'description' => 'ALTER TABLE admin_activity_log ADD COLUMN description TEXT NULL AFTER entity_id',
        'ip_address' => 'ALTER TABLE admin_activity_log ADD COLUMN ip_address VARCHAR(45) NULL AFTER description',
        'user_agent' => 'ALTER TABLE admin_activity_log ADD COLUMN user_agent VARCHAR(255) NULL AFTER ip_address',
    ];

    foreach ($missingColumns as $column => $sql) {
        if (!admin_log_column_exists($conn, $column)) {
            $conn->query($sql);
        }
    }

    $ready = true;
}

function admin_log_action(mysqli $conn, string $action, string $entityType, ?int $entityId = null, ?string $description = null): void
{
    ensureAdminActivityLogSchema($conn);

    $adminId = isset($_SESSION['admin_id']) ? (int) $_SESSION['admin_id'] : null;
    $adminUsername = $_SESSION['admin_username'] ?? 'admin';
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    if ($stmt = $conn->prepare('INSERT INTO admin_activity_log (admin_id, admin_username, action, entity_type, entity_id, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
        $stmt->bind_param(
            'isssisss',
            $adminId,
            $adminUsername,
            $action,
            $entityType,
            $entityId,
            $description,
            $ipAddress,
            $userAgent
        );
        $stmt->execute();
        $stmt->close();
    }
}
