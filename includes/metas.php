<?php
// includes/metas.php
$pageSlug = $pageSlug ?? basename($_SERVER['PHP_SELF'] ?? 'index.php', '.php');

$metaDefaults = [
    'index' => [
        'title' => 'Proyectos MCE | Desarrollo de Software a Medida en Colombia',
        'description' => 'Desarrollamos software a medida, automatizaciones e integraciones para optimizar operaciones, ventas e inventarios en empresas de Colombia y LATAM.',
        'keywords' => 'desarrollo software a medida, software empresarial colombia, automatizacion de procesos, sistemas web colombia',
    ],
    'servicios' => [
        'title' => 'Servicios de Desarrollo y Automatización | Proyectos MCE',
        'description' => 'Conoce nuestros servicios: desarrollo web a medida, sistemas de inventario, UX/UI, integraciones API, e-commerce y soporte continuo.',
        'keywords' => 'servicios desarrollo web, integraciones API, sistema inventario, e-commerce a medida, ux ui colombia',
    ],
    'portafolio' => [
        'title' => 'Portafolio de Proyectos Digitales | Proyectos MCE',
        'description' => 'Explora casos reales de Proyectos MCE: plataformas web, automatizaciones, paneles de operación y soluciones conectadas con APIs.',
        'keywords' => 'portafolio desarrollo web, casos de exito software, proyectos digitales colombia, sistemas empresariales',
    ],
    'contacto' => [
        'title' => 'Contacto y Agenda Discovery | Proyectos MCE',
        'description' => 'Agenda una sesión de discovery con Proyectos MCE y recibe una propuesta técnica para tu proyecto digital, con alcance y tiempos claros.',
        'keywords' => 'contacto proyectos mce, agendar discovery, cotizar desarrollo software, asesoria tecnologica',
    ],
    'testimonios' => [
        'title' => 'Testimonios de Clientes | Proyectos MCE',
        'description' => 'Lee testimonios de clientes que implementaron soluciones con Proyectos MCE para mejorar su operación y sus resultados.',
        'keywords' => 'testimonios desarrollo software, opiniones clientes proyectos mce, casos reales',
    ],
    'aviso-legal' => [
        'title' => 'Aviso Legal | Proyectos MCE',
        'description' => 'Consulta el aviso legal de Proyectos MCE con información sobre uso del sitio, responsabilidades y condiciones generales.',
        'keywords' => 'aviso legal proyectos mce, condiciones de uso',
    ],
    'politica-privacidad' => [
        'title' => 'Política de Privacidad | Proyectos MCE',
        'description' => 'Conoce cómo Proyectos MCE trata y protege tus datos personales de acuerdo con nuestra política de privacidad.',
        'keywords' => 'politica de privacidad proyectos mce, tratamiento de datos',
    ],
];

$defaultConfig = [
    'title' => 'Proyectos MCE | Desarrollo de Software a Medida y Automatización',
    'description' => 'Transformamos empresas con software robusto: sistemas de inventario, CRM, portales de clientes y automatización de procesos.',
    'keywords' => 'proyectos mce, desarrollo web, software a medida',
];

$pageMeta = $metaDefaults[$pageSlug] ?? $defaultConfig;

$meta_titulo = $meta_titulo ?? $pageMeta['title'];
$meta_descripcion = $meta_descripcion ?? $pageMeta['description'];
$meta_keywords = $meta_keywords ?? $pageMeta['keywords'];
$meta_imagen = $meta_imagen ?? app_absolute_url('imag/MCE.jpg');
$meta_robots = $meta_robots ?? 'index, follow';
$meta_canonical = $meta_canonical ?? canonical_absolute_url();

$metaTitleEscaped = htmlspecialchars($meta_titulo, ENT_QUOTES, 'UTF-8');
$metaDescriptionEscaped = htmlspecialchars($meta_descripcion, ENT_QUOTES, 'UTF-8');
$metaKeywordsEscaped = htmlspecialchars($meta_keywords, ENT_QUOTES, 'UTF-8');
$metaImageEscaped = htmlspecialchars($meta_imagen, ENT_QUOTES, 'UTF-8');
$metaRobotsEscaped = htmlspecialchars($meta_robots, ENT_QUOTES, 'UTF-8');
$metaCanonicalEscaped = htmlspecialchars($meta_canonical, ENT_QUOTES, 'UTF-8');

$organizationSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'Proyectos MCE',
    'url' => app_absolute_url('/'),
    'logo' => app_absolute_url('imag/MCE.jpg'),
    'contactPoint' => [
        [
            '@type' => 'ContactPoint',
            'telephone' => '+57-311-412-5971',
            'contactType' => 'customer support',
            'areaServed' => 'CO',
            'availableLanguage' => ['es', 'en']
        ]
    ],
    'sameAs' => [
        'https://www.instagram.com/proyectosmce/',
        'https://www.linkedin.com/company/proyectosmce/',
        'https://www.facebook.com/proyectosmce',
        'https://www.tiktok.com/@proyectosmce'
    ]
];

$websiteSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'Proyectos MCE',
    'url' => app_absolute_url('/'),
    'inLanguage' => 'es-CO'
];

$webpageSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => $meta_titulo,
    'description' => $meta_descripcion,
    'url' => $meta_canonical,
    'inLanguage' => 'es-CO'
];
?>
<!-- Meta tags básicos -->
<meta name="description" content="<?php echo $metaDescriptionEscaped; ?>">
<meta name="keywords" content="<?php echo $metaKeywordsEscaped; ?>">
<meta name="author" content="Proyectos MCE">
<meta name="robots" content="<?php echo $metaRobotsEscaped; ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $metaCanonicalEscaped; ?>">
<meta property="og:title" content="<?php echo $metaTitleEscaped; ?>">
<meta property="og:description" content="<?php echo $metaDescriptionEscaped; ?>">
<meta property="og:image" content="<?php echo $metaImageEscaped; ?>">
<meta property="og:site_name" content="Proyectos MCE">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo $metaCanonicalEscaped; ?>">
<meta name="twitter:title" content="<?php echo $metaTitleEscaped; ?>">
<meta name="twitter:description" content="<?php echo $metaDescriptionEscaped; ?>">
<meta name="twitter:image" content="<?php echo $metaImageEscaped; ?>">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo $metaCanonicalEscaped; ?>">

<!-- Structured Data -->
<script type="application/ld+json"><?php echo json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<script type="application/ld+json"><?php echo json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<script type="application/ld+json"><?php echo json_encode($webpageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
