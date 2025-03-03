CREATE DATABASE checkin_hotel;
USE checkin_hotel;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    tipo_documento VARCHAR(50) NOT NULL,
    numero_documento VARCHAR(50) UNIQUE NOT NULL,
    fecha_expedicion DATE NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    sexo ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    nacionalidad VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    pais VARCHAR(100) NOT NULL,
    correo VARCHAR(255) UNIQUE NOT NULL,
    num_soporte VARCHAR(50) NULL,
    relacion_parentesco VARCHAR(100) NULL,
    edad INT NULL,
    CONSTRAINT chk_num_soporte CHECK (tipo_documento = 'DNI' OR num_soporte IS NULL),
    CONSTRAINT chk_relacion_parentesco CHECK (relacion_parentesco IS NULL or edad>=14)
);

-- Tabla de reservas
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla de valoraciones
CREATE TABLE valoraciones (
    id_valoracion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    comentario TEXT NOT NULL,
    puntuacion INT  NOT NULL CHECK (puntuacion BETWEEN 1 AND 5),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla de servicios
CREATE TABLE servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

-- Tabla de contrataciones de servicios
CREATE TABLE contrataciones (
    id_contratacion INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT NOT NULL,
    id_servicio INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva) ON DELETE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON DELETE CASCADE
);

CREATE TRIGGER actualizar_edad
BEFORE INSERT ON usuarios
FOR EACH ROW 
SET NEW.edad = TIMESTAMPDIFF(YEAR, NEW.fecha_nacimiento, CURDATE());

