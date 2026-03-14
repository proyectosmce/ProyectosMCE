-- NOTA HOSTING: en InfinityFree selecciona antes tu base if0_XXXXXXXX_proyectosmce en phpMyAdmin.
-- Si trabajas en local (XAMPP), puedes descomentar las dos líneas siguientes para crearla y usarla.
-- CREATE DATABASE IF NOT EXISTS proyectosmce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE proyectosmce;

-- Tabla de proyectos (portafolio)
CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    categoria VARCHAR(100),
    url_demo VARCHAR(255),
    url_repo VARCHAR(255),
    cliente VARCHAR(200),
    fecha_completado DATE,
    destacado BOOLEAN DEFAULT FALSE,
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    icono VARCHAR(100),
    precio_desde DECIMAL(10,2),
    destacado BOOLEAN DEFAULT FALSE,
    orden INT DEFAULT 0
) ENGINE=InnoDB;

-- Tabla de mensajes de contacto
CREATE TABLE IF NOT EXISTS mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(50),
    mensaje TEXT NOT NULL,
    leido BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de usuarios (admin)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de pagos (cobros de clientes)
CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(150) NOT NULL,
    proyecto VARCHAR(150),
    monto DECIMAL(12,2) NOT NULL,
    moneda VARCHAR(10) DEFAULT 'USD',
    metodo VARCHAR(50) DEFAULT 'transferencia',
    estado ENUM('pendiente','en_revision','confirmado','fallido','reembolsado') DEFAULT 'pendiente',
    fee_pasarela DECIMAL(12,2) DEFAULT 0,
    fecha_pago DATE NOT NULL,
    fecha_confirmacion DATETIME NULL,
    comprobante VARCHAR(255),
    notas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de ventas (inventario de proyectos vendidos)
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proyecto VARCHAR(150) NOT NULL,
    cliente VARCHAR(150),
    precio DECIMAL(12,2) NOT NULL,
    descuento DECIMAL(12,2) DEFAULT 0,
    estado_entrega ENUM('pendiente','entregado','soporte') DEFAULT 'pendiente',
    fecha_venta DATE NOT NULL,
    pago_id INT NULL,
    notas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_ventas_pago FOREIGN KEY (pago_id) REFERENCES pagos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de gastos
CREATE TABLE IF NOT EXISTS gastos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    proveedor VARCHAR(150),
    proyecto VARCHAR(150),
    monto DECIMAL(12,2) NOT NULL,
    moneda VARCHAR(10) DEFAULT 'USD',
    impuesto DECIMAL(12,2) DEFAULT 0,
    fecha_gasto DATE NOT NULL,
    metodo VARCHAR(50) DEFAULT 'transferencia',
    comprobante VARCHAR(255),
    notas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertar usuario admin por defecto (contraseña: admin123)
-- IMPORTANTE: Cambiá esta contraseña después
INSERT INTO usuarios (username, password_hash, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@proyectosmce.com');

-- Insertar datos de ejemplo
INSERT INTO proyectos (titulo, descripcion, imagen, categoria, destacado, orden) VALUES
('Sistema Inventario Oro Laminado', 'Sistema completo con carrito de compras, gestión de garantías y control de stock para tienda de joyería.', 'inventario-oro.jpg', 'Sistemas Web', TRUE, 1),
('Tienda Online Ropa', 'E-commerce con pasarela de pagos y panel administrativo.', 'tienda-ropa.jpg', 'E-commerce', FALSE, 2),
('Landing Page Inmobiliaria', 'Página profesional para mostrar propiedades y captar leads.', 'inmobiliaria.jpg', 'Landing Page', FALSE, 3);

INSERT INTO servicios (titulo, descripcion, icono, precio_desde, destacado, orden) VALUES
('Desarrollo Web a Medida', 'Sistemas personalizados según tus necesidades. Como el sistema de inventario que ves en el portafolio.', 'code', 1500.00, TRUE, 1),
('Tiendas Online', 'Vende por internet con carrito, pasarela de pagos y administración de productos.', 'shopping-cart', 2000.00, TRUE, 2),
('Sistemas de Inventario', 'Control de stock, ventas, garantías y reportes. Ideal para pequeños negocios.', 'boxes', 1200.00, TRUE, 3),
('Landing Pages', 'Páginas profesionales para campañas de marketing o presentación de servicios.', 'file-alt', 800.00, FALSE, 4);
