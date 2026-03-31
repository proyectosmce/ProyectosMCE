<?php
// includes/metas.php
$meta_titulo = $meta_titulo ?? 'Proyectos MCE | Desarrollo de Software a Medida y Automatización';
$meta_descripcion = $meta_descripcion ?? 'Transformamos empresas con software robusto: sistemas de inventario, CRM, portales de clientes y automatización de procesos. Software real para problemas reales en Colombia.';
$meta_imagen = $meta_imagen ?? app_absolute_url('imag/MCE.jpg');
?>
<!-- Meta tags básicos -->
<meta name="description" content="<?php echo $meta_descripcion; ?>">
<meta name="keywords" content="desarrollo web, sistemas a medida, software colombia, aplicaciones web, inventarios pro, proyectos mce">
<meta name="author" content="Proyectos MCE">
<meta name="robots" content="index, follow">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo current_absolute_url(); ?>">
<meta property="og:title" content="<?php echo $meta_titulo; ?>">
<meta property="og:description" content="<?php echo $meta_descripcion; ?>">
<meta property="og:image" content="<?php echo $meta_imagen; ?>">
<meta property="og:site_name" content="Proyectos MCE">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo current_absolute_url(); ?>">
<meta property="twitter:title" content="<?php echo $meta_titulo; ?>">
<meta property="twitter:description" content="<?php echo $meta_descripcion; ?>">
<meta property="twitter:image" content="<?php echo $meta_imagen; ?>">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo current_absolute_url(); ?>">
