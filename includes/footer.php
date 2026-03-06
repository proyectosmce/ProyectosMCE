    </main>
    
    <!-- Footer profesional -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Col 1: Logo y descripción -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Proyectos MCE</h3>
                    <p class="text-gray-400">Transformamos tus ideas en código. Soluciones web profesionales a medida.</p>
                </div>
                
                <!-- Col 2: Enlaces rápidos -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?php echo app_url(); ?>" class="hover:text-white transition">Inicio</a></li>
                        <li><a href="<?php echo app_url('servicios.php'); ?>" class="hover:text-white transition">Servicios</a></li>
                        <li><a href="<?php echo app_url('portafolio.php'); ?>" class="hover:text-white transition">Portafolio</a></li>
                        <li><a href="<?php echo app_url('testimonios.php'); ?>" class="hover:text-white transition">Testimonios</a></li>
                        <li><a href="<?php echo app_url('contacto.php'); ?>" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                
                <!-- Col 3: Servicios -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Servicios</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Desarrollo a Medida</li>
                        <li>Tiendas Online</li>
                        <li>Sistemas de Inventario</li>
                        <li>Mantenimiento Web</li>
                    </ul>
                </div>
                
                <!-- Col 4: Contacto -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="mailto:proyectosmceaa@gmail.com" class="inline-flex items-center hover:text-white transition"><i class="fas fa-envelope mr-2"></i><span>proyectosmceaa@gmail.com</span></a></li>
                        <li><i class="fas fa-phone mr-2"></i> +57 311 412 59 71</li>
                        <li class="flex flex-wrap items-center gap-4 mt-4">
                            <a href="https://wa.me/573114125971?text=Hola%21%20Quiero%20consultar%20por%20un%20proyecto" target="_blank" rel="noopener" class="inline-flex text-gray-400 hover:text-white text-xl" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://t.me/proyectosmce" target="_blank" rel="noopener" class="inline-flex text-gray-400 hover:text-white text-xl" aria-label="Telegram"><i class="fab fa-telegram-plane"></i></a>
                            <a href="https://www.instagram.com/proyectosmce/" target="_blank" rel="noopener" class="inline-flex text-gray-400 hover:text-white text-xl" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/company/proyectosmce/" target="_blank" rel="noopener" class="inline-flex text-gray-400 hover:text-white text-xl" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                            <a href="https://www.facebook.com/proyectosmce" target="_blank" rel="noopener" class="inline-flex text-gray-400 hover:text-white text-xl" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.tiktok.com/@proyectosmce" target="_blank" rel="noopener" class="inline-flex text-gray-400 hover:text-white text-xl" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Proyectos MCE. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Botón flotante de WhatsApp -->
    <a href="https://wa.me/573114125971?text=Hola%21%20Quiero%20consultar%20por%20un%20proyecto"
       target="_blank"
       class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 hover:scale-110 z-50 group">
        <i class="fab fa-whatsapp text-3xl"></i>
        <span class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-1 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
            ¡Chatea con nosotros!
        </span>
    </a>
    
    <!-- Script para menú móvil -->
    <script>
        document.getElementById('menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    
    <!-- Tu script personalizado -->
    <script src="<?php echo app_url('assets/js/script.js'); ?>"></script>
</body>
</html>
