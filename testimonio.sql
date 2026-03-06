CREATE TABLE IF NOT EXISTS testimonios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cargo VARCHAR(100),
    empresa VARCHAR(100),
    testimonio TEXT NOT NULL,
    foto VARCHAR(255),
    valoracion INT DEFAULT 5, -- 1 a 5 estrellas
    proyecto_id INT,
    destacado BOOLEAN DEFAULT FALSE,
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Testimonios de ejemplo
INSERT INTO testimonios (nombre, cargo, empresa, testimonio, valoracion, proyecto_id, destacado) VALUES
('María González', 'Dueña', 'Joyas M&G', 'El sistema de inventario que me desarrollaron es exactamente lo que necesitaba. Ahora puedo controlar el stock, las ventas y las garantías sin problemas. Mi negocio creció un 40% desde que lo implementamos.', 5, 1, TRUE),
('Carlos Rodríguez', 'Gerente', 'ElectroShop', 'Excelente servicio y atención. La tienda online quedó espectacular y las ventas aumentaron considerablemente. Muy recomendados.', 5, 2, TRUE),
('Ana Martínez', 'Emprendedora', NULL, 'Trabajar con Proyectos MCE fue una experiencia increíble. Entendieron mi idea y la superaron. El sistema de inventario para mi tienda de accesorios funciona de maravilla.', 5, 1, FALSE);