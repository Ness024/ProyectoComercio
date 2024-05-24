
-- Tabla Usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    Fecha_Nacimiento DATE,
    Sexo VARCHAR(15),
    celular VARCHAR(15),
    numero_cliente VARCHAR(20),
    -- Domicilio
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Domicilios:

CREATE TABLE domicilios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    direccion VARCHAR(255),
    colonia VARCHAR(50),
    ciudad VARCHAR(50),
    codigo_postal VARCHAR(10),
    nro_exterior VARCHAR(10),
    nro_interior VARCHAR(10),
    descripcion VARCHAR(255),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla Categorias

CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla productos
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    imagen VARCHAR(255),
    rate INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE Ordenes (
    IDOrden INT PRIMARY KEY AUTO_INCREMENT,
    IDUsuario INT,
    IDDireccion INT,
    IDMetodoPago INT,
    Total DECIMAL(10, 2),
    EstadoOrden VARCHAR(50),
    Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IDUsuario) REFERENCES usuarios(id),
    FOREIGN KEY (IDDireccion) REFERENCES domicilios(id),
    FOREIGN KEY (IDMetodoPago) REFERENCES tarjetas(id)
);

-- Tabla de Detalles de Órdenes
CREATE TABLE DetallesOrden (
    IDDetalle INT PRIMARY KEY AUTO_INCREMENT,
    IDOrden INT,
    IDProducto INT,
    Cantidad INT,
    Precio DECIMAL(10, 2),
    FOREIGN KEY (IDOrden) REFERENCES Ordenes(IDOrden),
    FOREIGN KEY (IDProducto) REFERENCES productos(id)
);

SELECT
MAX(u.nombre) as nombre, MAX(u.apellidos) as apellidos,
MAX(d.direccion) as direccion, MAX(d.colonia) as colonia, MAX(d.ciudad) as ciudad, MAX(d.codigo_postal) as codigo_postal,
MAX(t.apellido_titular) as apellido_titular, MAX(RIGHT(t.numero_tarjeta, 4)) as ultimos_digitos, MAX(t.fecha_expiracion) as fecha_expiracion,
SUM(c.cantidad) as cantidad_total, SUM(c.cantidad) as total_pagar
 FROM usuarios u
 JOIN domicilios d ON u.id = d.usuario_id
 JOIN tarjetas t ON u.id = t.usuario_id
 JOIN carrito_compras c ON u.id = c.usuario_id
 WHERE u.id = 5
 GROUP BY u.id;
-- tabla pedidos definitivo

CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    cantidad_productos DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'pendiente',
    direccion_envio VARCHAR(255) NOT NULL,
    ciudad_envio VARCHAR(50) NOT NULL,
    codigo_postal_envio VARCHAR(10) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    informacion_pago TEXT, 
    estado_pago VARCHAR(20) DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Carrito de Compras

CREATE TABLE carrito_compras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    producto_id INT,
    cantidad INT,
    total DECIMAL(10, 2),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);


-- Historial de Compras:

CREATE TABLE historial_compras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    producto_id INT,
    cantidad INT,
    total DECIMAL(10, 2),
    fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);


CREATE TABLE tarjetas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    primer_nombre VARCHAR(50),
    segundo_nombre VARCHAR(50),
    apellido_titular VARCHAR(50) NOT NULL,
    numero_tarjeta VARCHAR(16) NOT NULL,
    fecha_expiracion VARCHAR(5) NOT NULL,
    cvv VARCHAR(4) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-------TABLAS EXTRA---------------------

-- Tabla Productos Favoritos
CREATE TABLE productos_favoritos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    producto_id INT,
    fecha_guardado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla Comentarios y valoraciones

CREATE TABLE comentarios_valoraciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    producto_id INT,
    puntuacion INT NOT NULL,
    comentario TEXT,
    fecha_valoracion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);


----------YA NO XD----------------------------


--Facturas
CREATE TABLE facturas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    total DECIMAL(10, 2),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla Pedidos

CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla de detalles de pedidos

CREATE TABLE detalles_pedido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT,
    producto_id INT,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);


--Formas de Pago

CREATE TABLE formas_pago (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    tipo VARCHAR(50),
    numero VARCHAR(20),
    fecha_expiracion DATE,
    cvv VARCHAR(10),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);


INSERT INTO categorias (nombre) VALUES
('Agua dulce'),
('Agua salada'),
('Reptiles'),
('Roedores'),
('Perros'),
('Gatos'),
('Alimentos'),
('Plantas');