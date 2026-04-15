<?php

function fetchPortfolioProjects(mysqli $conn): array
{
    $projects = [];
    $sql = "SELECT id, titulo, descripcion, imagen, categoria, url_demo, url_repo, cliente, fecha_completado, destacado, orden
            FROM proyectos
            ORDER BY destacado DESC, orden ASC, id DESC";

    $result = $conn->query($sql);
    if (!$result instanceof mysqli_result) {
        return $projects;
    }

    while ($row = $result->fetch_assoc()) {
        $row['categoria'] = trim((string) ($row['categoria'] ?? '')) ?: 'Sin categoria';
        $row['public_url'] = getProjectPublicUrl($row);
        $row['image_url'] = getProjectImageUrl($row);
        $projects[] = $row;
    }

    $result->free();

    return $projects;
}

function fetchProjectDropdownOptions(mysqli $conn): array
{
    $options = [];

    foreach (fetchPortfolioProjects($conn) as $project) {
        $options[] = [
            'id' => (int) ($project['id'] ?? 0),
            'titulo' => (string) ($project['titulo'] ?? ''),
            'categoria' => (string) ($project['categoria'] ?? ''),
        ];
    }

    return $options;
}

function fetchPortfolioCategories(array $projects): array
{
    $categories = [];

    foreach ($projects as $project) {
        $category = trim((string) ($project['categoria'] ?? ''));
        if ($category === '' || isset($categories[$category])) {
            continue;
        }

        $categories[$category] = true;
    }

    return array_keys($categories);
}

function getProjectPublicUrl(array $project): string
{
    $url = trim((string) ($project['url_demo'] ?? ''));
    if ($url !== '') {
        if (preg_match('~^(https?://|/|#)~i', $url) === 1) {
            return $url;
        }

        return app_url($url);
    }

    $customRoutes = [
        'destello de oro 18k' => app_url('destello-oro.php'),
    ];

    $title = trim((string) ($project['titulo'] ?? ''));
    if ($title !== '') {
        $norm = mb_strtolower($title, 'UTF-8');
        if (isset($customRoutes[$norm])) {
            return $customRoutes[$norm];
        }
    }

    return '#';
}

function isExternalProjectUrl(string $url): bool
{
    return preg_match('~^https?://~i', $url) === 1;
}

function isRealCaseProject(array $project): bool
{
    $title = trim((string) ($project['titulo'] ?? ''));
    if ($title !== '' && normalizeProjectIdentity($title) === normalizeProjectIdentity('Destello de Oro 18K')) {
        return true;
    }

    $urlDemo = trim((string) ($project['url_demo'] ?? ''));
    if ($urlDemo !== '' && stripos($urlDemo, 'destello-oro') !== false) {
        return true;
    }

    $publicUrl = trim((string) ($project['public_url'] ?? ''));
    if ($publicUrl !== '' && stripos($publicUrl, 'destello-oro') !== false) {
        return true;
    }

    return false;
}

function getProjectImageUrl(array $project): string
{
    $image = trim((string) ($project['imagen'] ?? ''));
    if ($image === '') {
        return app_url('fondo.jpeg');
    }

    if (preg_match('~^https?://~i', $image) === 1) {
        return $image;
    }

    $normalized = normalizeProjectImagePath($image);
    $resolved = resolveProjectImagePath($normalized);

    if ($resolved !== null) {
        return projectAssetUrl($resolved);
    }

    return projectAssetUrl(fallbackProjectImagePath($normalized));
}

function projectAssetUrl(string $path): string
{
    $normalized = trim(str_replace('\\', '/', $path), '/');
    $segments = array_map('rawurlencode', explode('/', $normalized));

    return app_url(implode('/', $segments));
}

function normalizeProjectImagePath(string $image): string
{
    $normalized = trim(str_replace('\\', '/', $image), '/');
    if ($normalized === '') {
        return '';
    }

    $basePath = trim(app_base_path(), '/');
    if ($basePath !== '' && stripos($normalized, $basePath . '/') === 0) {
        $normalized = substr($normalized, strlen($basePath) + 1);
    }

    // Compatibilidad con rutas viejas guardadas como /proyectosmce/...
    if (stripos($normalized, 'proyectosmce/') === 0) {
        $normalized = substr($normalized, strlen('proyectosmce/'));
    }

    return trim($normalized, '/');
}

function resolveProjectImagePath(string $normalized): ?string
{
    if ($normalized === '') {
        return null;
    }

    foreach (buildProjectImageCandidates($normalized) as $candidate) {
        $resolved = resolveRelativeFileCaseInsensitive($candidate);
        if ($resolved !== null) {
            return $resolved;
        }
    }

    return null;
}

function buildProjectImageCandidates(string $normalized): array
{
    $candidates = [];
    $baseCandidates = [];

    $baseCandidates[] = $normalized;

    if (stripos($normalized, 'assets/img/') !== 0) {
        $baseCandidates[] = 'assets/img/' . $normalized;
    }

    if (stripos($normalized, 'assets/img/proyectos/') !== 0) {
        $baseCandidates[] = 'assets/img/proyectos/' . $normalized;
    }

    $hasExtension = preg_match('~\.[a-z0-9]{2,5}$~i', $normalized) === 1;
    $extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg'];

    foreach ($baseCandidates as $baseCandidate) {
        $candidates[] = $baseCandidate;

        if (!$hasExtension) {
            foreach ($extensions as $ext) {
                $candidates[] = $baseCandidate . '.' . $ext;
            }
        }
    }

    return array_values(array_unique($candidates));
}

function resolveRelativeFileCaseInsensitive(string $relativePath): ?string
{
    $relativePath = trim(str_replace('\\', '/', $relativePath), '/');
    if ($relativePath === '' || strpos($relativePath, '..') !== false) {
        return null;
    }

    $projectRoot = realpath(__DIR__ . '/..');
    if ($projectRoot === false) {
        return null;
    }

    $segments = array_values(array_filter(explode('/', $relativePath), 'strlen'));
    $currentPath = $projectRoot;
    $resolvedSegments = [];

    foreach ($segments as $segment) {
        if ($segment === '.' || $segment === '..') {
            return null;
        }

        $entries = @scandir($currentPath);
        if (!is_array($entries)) {
            return null;
        }

        $matchedEntry = null;
        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            if (strcasecmp($entry, $segment) === 0) {
                $matchedEntry = $entry;
                break;
            }
        }

        if ($matchedEntry === null) {
            return null;
        }

        $resolvedSegments[] = $matchedEntry;
        $currentPath .= DIRECTORY_SEPARATOR . $matchedEntry;
    }

    if (!is_file($currentPath)) {
        return null;
    }

    return implode('/', $resolvedSegments);
}

function fallbackProjectImagePath(string $normalized): string
{
    if ($normalized === '') {
        return 'fondo.jpeg';
    }

    if (strpos($normalized, '/') !== false) {
        return $normalized;
    }

    return 'assets/img/' . $normalized;
}

function normalizeProjectIdentity(string $value): string
{
    $value = mb_strtolower(trim($value), 'UTF-8');
    $map = [
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ñ' => 'n',
    ];

    return strtr($value, $map);
}
