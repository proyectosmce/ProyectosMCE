<?php require_once 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- Título de página -->
<section class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Nuestros Servicios</h1>
        <p class="text-xl text-gray-600">Soluciones profesionales para tu negocio</p>
    </div>
</section>

<!-- Lista de servicios -->
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $result = $conn->query("SELECT * FROM servicios ORDER BY orden");
        while ($row = $result->fetch_assoc()):
        ?>
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

<?php include 'includes/footer.php'; ?>
