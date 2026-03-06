<?php require_once 'includes/config.php'; ?>
<?php require_once 'includes/project-helpers.php'; ?>
<?php
$projects = fetchPortfolioProjects($conn);
$categories = fetchPortfolioCategories($projects);
?>
<?php include 'includes/header.php'; ?>

<!-- Título de página -->
<section class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Portafolio</h1>
        <p class="text-xl text-gray-600">Proyectos que hablan por sí mismos</p>
    </div>
</section>

<!-- Filtros -->
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-wrap gap-2">
        <button class="filter-btn active px-4 py-2 rounded-full bg-blue-600 text-white" data-filter="all">Todos</button>
        <?php foreach ($categories as $category): ?>
            <button class="filter-btn px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300" data-filter="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
            </button>
        <?php endforeach; ?>
    </div>
</section>

<!-- Grid de proyectos -->
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="proyectos-grid">
        <?php if (!$projects): ?>
            <div class="md:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-600">
                Aún no hay proyectos publicados en el portafolio.
            </div>
        <?php endif; ?>

        <?php foreach ($projects as $project): ?>
            <?php
            $projectUrl = $project['public_url'];
            $hasLink = $projectUrl !== '#';
            $isExternal = $hasLink && isExternalProjectUrl($projectUrl);
            $description = trim((string) ($project['descripcion'] ?? ''));
            if ($description === '') {
                $description = 'Proyecto publicado en el portafolio de Proyectos MCE.';
            }
            if (function_exists('mb_strimwidth')) {
                $descriptionPreview = mb_strimwidth($description, 0, 110, '...');
            } else {
                $descriptionPreview = strlen($description) > 110 ? substr($description, 0, 110) . '...' : $description;
            }
            $clientLabel = trim((string) ($project['cliente'] ?? '')) ?: 'Cliente privado';
            ?>
            <div class="proyecto-item bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition" data-categoria="<?php echo htmlspecialchars($project['categoria'], ENT_QUOTES, 'UTF-8'); ?>">
                <a
                    href="<?php echo htmlspecialchars($projectUrl, ENT_QUOTES, 'UTF-8'); ?>"
                    <?php echo $isExternal ? 'target="_blank" rel="noopener"' : ''; ?>
                    class="block <?php echo $hasLink ? '' : 'pointer-events-none'; ?>"
                >
                    <img
                        src="<?php echo htmlspecialchars($project['image_url'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($project['titulo'], ENT_QUOTES, 'UTF-8'); ?>"
                        class="w-full h-48 object-cover hover:scale-[1.01] transition-transform duration-200"
                    >
                </a>
                <div class="p-6">
                    <span class="text-sm text-blue-600 font-semibold"><?php echo htmlspecialchars($project['categoria'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <h3 class="text-xl font-bold mt-2 mb-2">
                        <a
                            href="<?php echo htmlspecialchars($projectUrl, ENT_QUOTES, 'UTF-8'); ?>"
                            <?php echo $isExternal ? 'target="_blank" rel="noopener"' : ''; ?>
                            class="hover:text-blue-600 transition <?php echo $hasLink ? '' : 'pointer-events-none'; ?>"
                        >
                            <?php echo htmlspecialchars($project['titulo'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($descriptionPreview, ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-gray-500"><?php echo htmlspecialchars($clientLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php if ($hasLink): ?>
                            <a
                                href="<?php echo htmlspecialchars($projectUrl, ENT_QUOTES, 'UTF-8'); ?>"
                                <?php echo $isExternal ? 'target="_blank" rel="noopener"' : ''; ?>
                                class="text-blue-600 hover:underline"
                            >
                                Ver más →
                            </a>
                        <?php else: ?>
                            <span class="text-sm text-gray-400">Sin enlace disponible</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
// Filtro simple con JavaScript
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Actualizar botones activos
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-blue-600', 'text-white');
            b.classList.add('bg-gray-200');
        });
        this.classList.add('bg-blue-600', 'text-white');
        this.classList.remove('bg-gray-200');
        
        // Filtrar proyectos
        const filter = this.dataset.filter;
        document.querySelectorAll('.proyecto-item').forEach(item => {
            if (filter === 'all' || item.dataset.categoria === filter) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
