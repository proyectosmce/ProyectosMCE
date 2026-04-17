<?php
// sitemap.php
header('Content-Type: application/xml; charset=UTF-8');
require_once 'includes/config.php';

$pages = [
    '',
    'servicios',
    'portafolio',
    'contacto',
    'testimonios'
];

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($pages as $page): ?>
    <url>
        <loc><?php echo app_absolute_url($page); ?></loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority><?php echo $page == '' ? '1.0' : '0.8'; ?></priority>
    </url>
    <?php endforeach; ?>
    
    <!-- Proyectos -->
    <?php
    $proyectos = $conn->query("SELECT id, titulo, created_at FROM proyectos");
    while($p = $proyectos->fetch_assoc()):
    ?>
    <url>
        <loc><?php echo app_absolute_url('portafolio'); ?>?id=<?php echo (int) $p['id']; ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($p['created_at'])); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php endwhile; ?>
</urlset>
