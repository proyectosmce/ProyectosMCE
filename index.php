<?php require_once 'includes/config.php'; ?>
<?php require_once 'includes/project-helpers.php'; ?>
<?php
$portfolioProjects = fetchPortfolioProjects($conn);
$featuredProject = $portfolioProjects[0] ?? null;

// Manejo de envío de testimonios (solo alta, sin edición)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'nuevo_testimonio') {
    $nombre  = trim($_POST['nombre'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $proyId  = (int) ($_POST['proyecto_id'] ?? 0);

    if ($nombre !== '' && $mensaje !== '' && $proyId > 0) {
        if ($stmt = $conn->prepare('INSERT INTO testimonios (nombre, testimonio, proyecto_id, valoracion, destacado) VALUES (?, ?, ?, 5, 0)')) {
            $stmt->bind_param('ssi', $nombre, $mensaje, $proyId);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?testimonio=ok#testimonios');
            exit;
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Section mejorado -->
<section class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 text-white overflow-hidden">
    <!-- Elementos decorativos de fondo -->
    <div class="absolute inset-0 bg-grid-white/10"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-transparent to-black/20"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-32 text-center">
        
        
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
            Transformamos tus <br>
            <span class="text-yellow-300">ideas y necesidades  <br>  en proyectos digitales</span>
        </h1>
        
        <p class="text-xl md:text-2xl mb-10 text-blue-100 max-w-3xl mx-auto">
            Desarrollamos sistemas web a medida, tiendas online y soluciones digitales 
            que hacen crecer tu negocio.
        </p>
        
        <!-- CTA buttons -->
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="<?php echo app_url('portafolio.php'); ?>" 
               class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                <i class="fas fa-eye mr-2"></i> Ver Proyectos
            </a>
            <a href="<?php echo app_url('contacto.php'); ?>" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition transform hover:scale-105">
                <i class="fas fa-rocket mr-2"></i> Empezar Proyecto
            </a>
        </div>
    </div>
    
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="white" fill-opacity="1"></path>
        </svg>
    </div>
</section>

<!-- Servicios Destacados -->
<section class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">¿Qué podemos hacer por ti?</h2>
    
    <div class="grid md:grid-cols-3 gap-8">
        <?php
        $result = $conn->query("SELECT * FROM servicios WHERE destacado = 1 ORDER BY orden LIMIT 3");
        while ($row = $result->fetch_assoc()):
        ?>
        <!-- En servicios.php, dentro del grid -->
        <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative overflow-hidden animate-on-scroll">
            <!-- Barra decorativa superior -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            
            <!-- Icono con animación -->
            <div class="text-5xl text-blue-600 mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                <i class="fas fa-<?php echo $row['icono'] ?? 'code'; ?>"></i>
            </div>
            
            <!-- Contenido -->
            <h3 class="text-2xl font-bold mb-3 group-hover:text-blue-600 transition"><?php echo $row['titulo']; ?></h3>
            <p class="text-gray-600 mb-4"><?php echo $row['descripcion']; ?></p>
            
            <!-- Precio y CTA -->
            <div class="flex justify-between items-center mb-4">
                <span class="text-3xl font-bold text-blue-600">$<?php echo number_format($row['precio_desde']); ?></span>
                <span class="text-gray-500 text-sm">+IVA</span>
            </div>
            
            <!-- Botón con efecto -->
            <a href="<?php echo app_url('contacto.php'); ?>?servicio=<?php echo urlencode($row['titulo']); ?>" 
               class="mt-4 inline-flex items-center text-blue-600 group-hover:text-blue-800 font-semibold">
                <span>Solicitar presupuesto</span>
                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-2 transition"></i>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Proyecto Destacado -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Proyecto Destacado</h2>
        <?php if ($featuredProject): ?>
            <?php
            $featuredUrl = $featuredProject['public_url'];
            $featuredHasLink = $featuredUrl !== '#';
            $featuredIsExternal = $featuredHasLink && isExternalProjectUrl($featuredUrl);
            $featuredDescription = trim((string) ($featuredProject['descripcion'] ?? '')) ?: 'Proyecto destacado del portafolio de Proyectos MCE.';
            $featuredClient = trim((string) ($featuredProject['cliente'] ?? '')) ?: 'Cliente privado';
            $featuredDate = null;
            if (!empty($featuredProject['fecha_completado'])) {
                $timestamp = strtotime((string) $featuredProject['fecha_completado']);
                if ($timestamp) {
                    $featuredDate = date('d/m/Y', $timestamp);
                }
            }
            $repoUrl = trim((string) ($featuredProject['url_repo'] ?? ''));
            if ($repoUrl !== '' && preg_match('~^(https?://|/)~i', $repoUrl) !== 1) {
                $repoUrl = 'https://' . $repoUrl;
            }
            ?>
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img
                            src="<?php echo htmlspecialchars($featuredProject['image_url'], ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?php echo htmlspecialchars($featuredProject['titulo'], ENT_QUOTES, 'UTF-8'); ?>"
                            class="w-full h-64 md:h-full object-cover"
                        >
                    </div>
                    <div class="md:w-1/2 p-8">
                        <span class="text-blue-600 font-semibold"><?php echo htmlspecialchars($featuredProject['categoria'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <h3 class="text-2xl font-bold mt-2 mb-4"><?php echo htmlspecialchars($featuredProject['titulo'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($featuredDescription, ENT_QUOTES, 'UTF-8'); ?></p>

                        <div class="grid sm:grid-cols-2 gap-3 text-gray-600 mb-6">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-tie text-blue-600"></i>
                                <span><?php echo htmlspecialchars($featuredClient, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-layer-group text-blue-600"></i>
                                <span><?php echo htmlspecialchars($featuredProject['categoria'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <?php if ($featuredDate): ?>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-blue-600"></i>
                                    <span><?php echo htmlspecialchars($featuredDate, ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-star text-blue-600"></i>
                                <span>Proyecto destacado</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <?php if ($featuredHasLink): ?>
                                <a
                                    href="<?php echo htmlspecialchars($featuredUrl, ENT_QUOTES, 'UTF-8'); ?>"
                                    <?php echo $featuredIsExternal ? 'target="_blank" rel="noopener"' : ''; ?>
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition"
                                >
                                    Ver proyecto
                                </a>
                            <?php endif; ?>

                            <?php if ($repoUrl !== ''): ?>
                                <a
                                    href="<?php echo htmlspecialchars($repoUrl, ENT_QUOTES, 'UTF-8'); ?>"
                                    target="_blank"
                                    rel="noopener"
                                    class="border border-slate-300 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-50 transition"
                                >
                                    Ver repositorio
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo app_url('portafolio.php'); ?>" class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition">
                                Ver más proyectos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-xl p-10 text-center text-gray-600">
                Aún no hay proyectos destacados publicados. Revisa el portafolio completo para ver los trabajos disponibles.
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
