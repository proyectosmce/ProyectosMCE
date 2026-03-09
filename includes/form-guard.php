<?php

function form_guard_normalize_whitespace(string $value): string
{
    return preg_replace('/\s+/u', ' ', trim($value)) ?? trim($value);
}

function form_guard_normalize_multiline(string $value): string
{
    $value = str_replace(["\r\n", "\r"], "\n", trim($value));
    $lines = array_map(static function ($line) {
        return form_guard_normalize_whitespace($line);
    }, explode("\n", $value));

    return trim(implode("\n", $lines));
}

function form_guard_client_ip(): string
{
    $candidates = [
        $_SERVER['HTTP_CF_CONNECTING_IP'] ?? null,
        $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
        $_SERVER['REMOTE_ADDR'] ?? null,
    ];

    foreach ($candidates as $candidate) {
        if (!$candidate) {
            continue;
        }

        foreach (explode(',', (string) $candidate) as $ip) {
            $ip = trim($ip);
            if ($ip !== '' && filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return 'unknown';
}

function form_guard_storage_path(): ?string
{
    static $storagePath = false;

    if ($storagePath !== false) {
        return $storagePath;
    }

    $dir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'proyectosmce-rate-limit';
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        $storagePath = null;
        return $storagePath;
    }

    if (!is_writable($dir)) {
        $storagePath = null;
        return $storagePath;
    }

    $storagePath = $dir;
    return $storagePath;
}

function form_guard_load_attempts(string $key): array
{
    $storagePath = form_guard_storage_path();
    if ($storagePath === null) {
        return $_SESSION['form_rate_limit'][$key] ?? [];
    }

    $filePath = $storagePath . DIRECTORY_SEPARATOR . hash('sha256', $key) . '.json';
    if (!is_file($filePath)) {
        return [];
    }

    $raw = @file_get_contents($filePath);
    if ($raw === false || $raw === '') {
        return [];
    }

    $decoded = json_decode($raw, true);
    return is_array($decoded) ? array_values(array_filter($decoded, 'is_numeric')) : [];
}

function form_guard_save_attempts(string $key, array $attempts): void
{
    $storagePath = form_guard_storage_path();
    if ($storagePath === null) {
        $_SESSION['form_rate_limit'][$key] = array_values($attempts);
        return;
    }

    $filePath = $storagePath . DIRECTORY_SEPARATOR . hash('sha256', $key) . '.json';
    @file_put_contents($filePath, json_encode(array_values($attempts)), LOCK_EX);
}

function form_guard_rate_limit(string $bucket, string $identifier, int $maxAttempts, int $windowSeconds): array
{
    $now = time();
    $key = $bucket . '|' . $identifier;
    $attempts = array_values(array_filter(form_guard_load_attempts($key), static function ($timestamp) use ($now, $windowSeconds) {
        return is_numeric($timestamp) && ((int) $timestamp) > ($now - $windowSeconds);
    }));

    if (count($attempts) >= $maxAttempts) {
        $retryAfter = max(1, $windowSeconds - ($now - (int) $attempts[0]));
        return [
            'allowed' => false,
            'retry_after' => $retryAfter,
        ];
    }

    $attempts[] = $now;
    form_guard_save_attempts($key, $attempts);

    return [
        'allowed' => true,
        'retry_after' => 0,
    ];
}

function form_guard_issue(string $formName): array
{
    if (!isset($_SESSION['form_guard'][$formName]) || !is_array($_SESSION['form_guard'][$formName])) {
        $_SESSION['form_guard'][$formName] = [];
    }

    $now = time();
    $_SESSION['form_guard'][$formName] = array_filter(
        $_SESSION['form_guard'][$formName],
        static function ($payload) use ($now) {
            return is_array($payload)
                && isset($payload['issued_at'])
                && is_numeric($payload['issued_at'])
                && ((int) $payload['issued_at']) >= ($now - 7200);
        }
    );

    $token = bin2hex(random_bytes(16));
    $_SESSION['form_guard'][$formName][$token] = [
        'issued_at' => $now,
    ];

    if (count($_SESSION['form_guard'][$formName]) > 5) {
        $_SESSION['form_guard'][$formName] = array_slice($_SESSION['form_guard'][$formName], -5, null, true);
    }

    return [
        'token' => $token,
        'issued_at' => $now,
    ];
}

function form_guard_verify(string $formName, ?string $token, int $minSeconds = 3, int $maxAgeSeconds = 7200): array
{
    if ($token === null || $token === '') {
        return [
            'ok' => false,
            'reason' => 'missing_token',
        ];
    }

    $payload = $_SESSION['form_guard'][$formName][$token] ?? null;
    unset($_SESSION['form_guard'][$formName][$token]);

    if (!is_array($payload) || !isset($payload['issued_at'])) {
        return [
            'ok' => false,
            'reason' => 'invalid_token',
        ];
    }

    $age = time() - (int) $payload['issued_at'];
    if ($age < $minSeconds) {
        return [
            'ok' => false,
            'reason' => 'submitted_too_fast',
        ];
    }

    if ($age > $maxAgeSeconds) {
        return [
            'ok' => false,
            'reason' => 'expired_token',
        ];
    }

    return [
        'ok' => true,
        'reason' => 'ok',
    ];
}

function form_guard_honeypot_is_clear(?string $value): bool
{
    return trim((string) $value) === '';
}

function form_guard_validate_name(string $value, int $minLength = 2, int $maxLength = 100): bool
{
    $value = form_guard_normalize_whitespace($value);
    $length = function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);

    if ($length < $minLength || $length > $maxLength) {
        return false;
    }

    if (preg_match('~https?://|www\.~i', $value) === 1) {
        return false;
    }

    return preg_match("/^[\p{L}\p{M}0-9][\p{L}\p{M}0-9 .,'-]*$/u", $value) === 1;
}

function form_guard_validate_phone(string $value): bool
{
    $value = trim($value);
    if ($value === '') {
        return true;
    }

    $digitCount = strlen((string) preg_replace('/\D+/', '', $value));
    if ($digitCount < 7 || $digitCount > 15) {
        return false;
    }

    return preg_match('/^[0-9+()\-\s]{7,25}$/', $value) === 1;
}

function form_guard_validate_message(string $value, int $minLength, int $maxLength): bool
{
    $value = form_guard_normalize_multiline($value);
    $length = function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);

    if ($length < $minLength || $length > $maxLength) {
        return false;
    }

    if (preg_match('~(.)\1{9,}~u', $value) === 1) {
        return false;
    }

    preg_match_all('~https?://|www\.~i', $value, $matches);
    return count($matches[0]) <= 2;
}

function form_guard_recaptcha_site_key(): string
{
    global $RECAPTCHA_SITE_KEY;

    return trim((string) ($RECAPTCHA_SITE_KEY ?? getenv('RECAPTCHA_SITE_KEY') ?: ''));
}

function form_guard_recaptcha_secret_key(): string
{
    global $RECAPTCHA_SECRET_KEY;

    return trim((string) ($RECAPTCHA_SECRET_KEY ?? getenv('RECAPTCHA_SECRET_KEY') ?: ''));
}

function form_guard_recaptcha_enabled(): bool
{
    return form_guard_recaptcha_site_key() !== '' && form_guard_recaptcha_secret_key() !== '';
}

function form_guard_verify_recaptcha(?string $responseToken): bool
{
    if (!form_guard_recaptcha_enabled()) {
        return false;
    }

    $responseToken = trim((string) $responseToken);
    if ($responseToken === '') {
        return false;
    }

    $payload = http_build_query([
        'secret' => form_guard_recaptcha_secret_key(),
        'response' => $responseToken,
        'remoteip' => form_guard_client_ip(),
    ]);

    $body = false;

    if (function_exists('curl_init')) {
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $body = curl_exec($ch);
        curl_close($ch);
    } else {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $payload,
                'timeout' => 10,
            ],
        ]);
        $body = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    }

    if ($body === false || $body === '') {
        return false;
    }

    $decoded = json_decode($body, true);
    return is_array($decoded) && !empty($decoded['success']);
}
