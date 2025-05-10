-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2025 a las 12:35:08
-- Versión del servidor: 8.0.33
-- Versión de PHP: 8.2.12
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Base de datos: `checkin_hotel`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `contrataciones`
--
CREATE TABLE `contrataciones` (
  `id_contratacion` int NOT NULL,
  `id_reserva` int NOT NULL,
  `id_servicio` int NOT NULL,
  `cantidad` int NOT NULL
);
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `reservas`
--
CREATE TABLE `reservas` (
  `id_reserva` int NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` enum('pendiente', 'confirmada', 'cancelada') COLLATE utf8mb4_general_ci NOT NULL,
  `usuarios_ids` json NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `servicios`
--
CREATE TABLE `servicios` (
  `id_servicio` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `precio` decimal(10, 2) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `tipo_documento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero_documento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_expedicion` date DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('Masculino', 'Femenino', 'Otro') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_soporte` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `relacion_parentesco` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('admin', 'usuario') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'usuario'
);
--
-- Disparadores `usuarios`
--
DELIMITER $$ CREATE TRIGGER `actualizar_edad` BEFORE
INSERT ON `usuarios` FOR EACH ROW
SET NEW.edad = TIMESTAMPDIFF(YEAR, NEW.fecha_nacimiento, CURDATE()) $$ DELIMITER;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `valoraciones`
--
CREATE TABLE `valoraciones` (
  `id_valoracion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_reserva` int NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci NOT NULL,
  `puntuacion` int NOT NULL
);
--
-- Índices para tablas volcadas
--
--
-- Indices de la tabla `contrataciones`
--
ALTER TABLE `contrataciones`
ADD PRIMARY KEY (`id_contratacion`),
  ADD KEY `id_reserva` (`id_reserva`),
  ADD KEY `id_servicio` (`id_servicio`);
--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
ADD PRIMARY KEY (`id_reserva`);
--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
ADD PRIMARY KEY (`id_servicio`);
--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `numero_documento_2` (`numero_documento`),
  ADD UNIQUE KEY `correo_2` (`correo`);
--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `id_usuario` (`id_usuario`);
--
-- AUTO_INCREMENT de las tablas volcadas
--
--
-- AUTO_INCREMENT de la tabla `contrataciones`
--
ALTER TABLE `contrataciones`
MODIFY `id_contratacion` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
MODIFY `id_reserva` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
MODIFY `id_servicio` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
MODIFY `id_valoracion` int NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--
--
-- Filtros para la tabla `contrataciones`
--
ALTER TABLE `contrataciones`
ADD CONSTRAINT `contrataciones_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE,
  ADD CONSTRAINT `contrataciones_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE;
--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;