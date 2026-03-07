<?php require_once 'includes/config.php'; ?>
<?php require_once 'includes/project-helpers.php'; ?>
<?php
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

<!-- Hero Section estilo iOS/glass -->
<section class="relative overflow-hidden bg-slate-50 text-slate-900">
    <div class="absolute inset-0">
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-blue-200/60 blur-3xl rounded-full"></div>
        <div class="absolute top-10 right-10 w-64 h-64 bg-indigo-200/60 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-white/80 blur-3xl rounded-full"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 lg:py-28">
        <div class="grid lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-6 text-left">
                <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-white/70 backdrop-blur-lg border border-white/80 rounded-full shadow-sm">
                    <i class="fas fa-sparkles mr-2 text-blue-600"></i>
                    Proyectos MCE · Software a medida
                </span>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                    Software a medida para que tu operación no se detenga
                </h1>
                <p class="text-lg md:text-xl text-slate-600 max-w-3xl">
                    Planificamos, diseñamos y desarrollamos plataformas web que soportan ventas, inventarios y atención al cliente con control total y visibilidad.
                </p>

                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur border border-slate-200 text-sm text-slate-700">
                        <i class="fas fa-diagram-project mr-2 text-blue-600"></i>Entendemos tu proceso primero
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur border border-slate-200 text-sm text-slate-700">
                        <i class="fas fa-pen-ruler mr-2 text-blue-600"></i>Diseñamos y prototipamos antes de programar
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur border border-slate-200 text-sm text-slate-700">
                        <i class="fas fa-bolt mr-2 text-blue-600"></i>Entregas cortas con pruebas y control
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur border border-slate-200 text-sm text-slate-700">
                        <i class="fas fa-database mr-2 text-blue-600"></i>Integraciones y datos en orden
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4 pt-2">
                    <a href="<?php echo app_url('contacto.php'); ?>" class="inline-flex items-center justify-center bg-slate-900 text-white px-8 py-4 rounded-xl font-semibold shadow-lg shadow-slate-400/30 hover:bg-slate-800 transition">
                        <i class="fas fa-rocket mr-2"></i> Armar mi plan
                    </a>
                    <a href="<?php echo app_url('portafolio.php'); ?>" class="inline-flex items-center justify-center border-2 border-slate-900 text-slate-900 px-8 py-4 rounded-xl font-semibold hover:bg-slate-900 hover:text-white transition">
                        <i class="fas fa-eye mr-2"></i> Ver casos en vivo
                    </a>
                    <a href="<?php echo app_url('servicios.php'); ?>" class="inline-flex items-center text-slate-600 hover:text-slate-900 font-semibold">
                        <span>Servicios</span>
                        <i class="fas fa-arrow-down ml-2"></i>
                    </a>
                </div>

                <div class="grid sm:grid-cols-3 gap-4 pt-6 border-t border-slate-200 max-w-4xl">
                    <div class="bg-white/80 backdrop-blur border border-slate-200 rounded-xl p-4 shadow-sm">
                        <p class="text-sm text-slate-500">Gobernanza</p>
                        <p class="text-lg font-semibold text-slate-900">Backlog claro, prioridades y criterios de entrega</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur border border-slate-200 rounded-xl p-4 shadow-sm">
                        <p class="text-sm text-slate-500">Entrega iterativa</p>
                        <p class="text-lg font-semibold text-slate-900">Demos quincenales, pruebas automáticas y regresiones</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur border border-slate-200 rounded-xl p-4 shadow-sm">
                        <p class="text-sm text-slate-500">Operabilidad</p>
                        <p class="text-lg font-semibold text-slate-900">Monitoreo, alertas y soporte continuo</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white/80 backdrop-blur-2xl border border-white/70 rounded-2xl p-8 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Hoja de ruta MCE</p>
                            <p class="text-2xl font-semibold text-slate-900">Tu proyecto, con control total</p>
                        </div>
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-900 text-white font-bold shadow-lg">MCE</span>
                    </div>
                    <ul class="space-y-3 text-slate-800">
                        <li class="flex items-start gap-3">
                            <span class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-900 text-white"><i class="fas fa-clipboard-check"></i></span>
                            <div>
                                <p class="font-semibold">Arranque y plan</p>
                                <p class="text-sm text-slate-600">Conversamos de tus procesos y definimos lo más importante primero.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-900 text-white"><i class="fas fa-pen-ruler"></i></span>
                            <div>
                                <p class="font-semibold">Diseño claro</p>
                                <p class="text-sm text-slate-600">Pantallas fáciles de usar para tu equipo y tus clientes.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-900 text-white"><i class="fas fa-bolt"></i></span>
                            <div>
                                <p class="font-semibold">Construcción por etapas</p>
                                <p class="text-sm text-slate-600">Avanzamos en ciclos cortos con avances y pruebas visibles.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-900 text-white"><i class="fas fa-shield-halved"></i></span>
                            <div>
                                <p class="font-semibold">Cuidado y soporte</p>
                                <p class="text-sm text-slate-600">Copias de seguridad, monitoreo y ayuda después de lanzar.</p>
                            </div>
                        </li>
                    </ul>
                    <a href="https://wa.me/573114125971?text=Hola%21%20Quiero%20agendar%20un%20discovery%20con%20MCE" target="_blank" rel="noopener" class="flex items-center justify-between p-4 rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition shadow-lg">
                        <div>
                            <p class="text-sm text-slate-200">Disponibilidad inmediata</p>
                            <p class="font-semibold">Agenda tu sesión de discovery sin costo</p>
                        </div>
                        <i class="fas fa-arrow-right text-white text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Métricas de confianza -->
<section class="max-w-7xl mx-auto px-4 -mt-10 lg:-mt-16">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 px-6 py-6 md:px-10 md:py-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-3xl font-bold text-slate-900">+120</p>
                <p class="text-sm text-gray-600">proyectos entregados</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-slate-900">&lt; 48h</p>
                <p class="text-sm text-gray-600">tiempo de respuesta</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-slate-900">99.9%</p>
                <p class="text-sm text-gray-600">uptime en soportes</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-slate-900">9.2/10</p>
                <p class="text-sm text-gray-600">satisfacción clientes</p>
            </div>
        </div>
    </div>
</section>

<!-- Presentación -->
<section class="relative max-w-7xl mx-auto px-4 -mt-10 lg:-mt-16">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="grid md:grid-cols-2">
            <div class="p-10 space-y-4">
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Presentación</p>
                <h2 class="text-3xl font-bold text-slate-900">Proyectos MCE </h2>
                <p class="text-gray-700 leading-relaxed">
                    Equipo con experiencia que entiende tu negocio, diseña la experiencia y entrega software confiable listo para producción.
                </p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="mt-1 text-blue-600"><i class="fas fa-magnifying-glass-chart"></i></span>
                        <p class="text-gray-800">Primero entendemos objetivos y quién usará la solución.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 text-blue-600"><i class="fas fa-laptop-code"></i></span>
                        <p class="text-gray-800">Definimos la base técnica para que crezca y se mantenga segura.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 text-blue-600"><i class="fas fa-people-group"></i></span>
                        <p class="text-gray-800">UX/UI centrado en usuarios internos y clientes para acelerar adopción.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 text-blue-600"><i class="fas fa-headset"></i></span>
                        <p class="text-gray-800">Seguimos contigo después de lanzar con monitoreo y mejoras planificadas.</p>
                    </div>
                </div>
            </div>
            <div class="p-10 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-800 text-white space-y-5">
                <h3 class="text-2xl font-bold">Cómo trabajamos</h3>
                <ul class="space-y-4 timeline">
                    <li class="flex items-start gap-3 timeline-item">
                        <span class="timeline-bullet w-8 h-8 rounded-full bg-white/15 flex items-center justify-center font-semibold">1</span>
                        <div>
                            <p class="font-semibold">Kickoff y plan</p>
                            <p class="text-sm text-blue-100">Revisamos tus objetivos y qué debe hacer la solución.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 timeline-item">
                        <span class="timeline-bullet w-8 h-8 rounded-full bg-white/15 flex items-center justify-center font-semibold">2</span>
                        <div>
                            <p class="font-semibold">Diseño y prototipos</p>
                            <p class="text-sm text-blue-100">Te mostramos maquetas para confirmar que el flujo es correcto.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 timeline-item">
                        <span class="timeline-bullet w-8 h-8 rounded-full bg-white/15 flex items-center justify-center font-semibold">3</span>
                        <div>
                            <p class="font-semibold">Desarrollo incremental</p>
                            <p class="text-sm text-blue-100">Entregamos en ciclos cortos con pruebas y notas claras.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 timeline-item">
                        <span class="timeline-bullet w-8 h-8 rounded-full bg-white/15 flex items-center justify-center font-semibold">4</span>
                        <div>
                            <p class="font-semibold">Lanzamiento y soporte</p>
                            <p class="text-sm text-blue-100">Publicamos, monitoreamos y mejoramos de forma continua.</p>
                        </div>
                    </li>
                </ul>
                <div class="p-4 border border-white/20 rounded-xl bg-white/10">
                    <p class="text-sm text-blue-100">Disponibilidad</p>
                    <p class="font-semibold">Equipo listo para comenzar en menos de 7 días</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
