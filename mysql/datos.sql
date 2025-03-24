-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2025 a las 12:16:44
-- Versión del servidor: 8.0.33
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `checkin_hotel`
--

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `fecha_entrada`, `fecha_salida`, `estado`, `usuarios_ids`) VALUES
(1, '2025-03-04', '2025-03-05', 'pendiente', '[1, 2]'),
(2, '2025-03-19', '2025-03-22', 'pendiente', '[1]');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `tipo_documento`, `numero_documento`, `fecha_expedicion`, `nombre`, `apellidos`, `fecha_nacimiento`, `sexo`, `nacionalidad`, `direccion`, `pais`, `correo`, `num_soporte`, `relacion_parentesco`, `edad`, `password_hash`, `rol`) VALUES
(1, 'DNI', '02791496D', '2022-08-20', 'CARLA', 'ACEBES MONTALVILLO', '2011-03-05', 'Femenino', 'FRANCIA', 'Facultad de Informática', 'FRANCIA', 'dadela03@ucm.es', 'ABC123456', NULL, NULL, '$2y$10$UxEtJnQbsboIgqQnOrjETeRFzlzTub2IcbfpqT01//G5wgWA8Hf/C', 'usuario'),
(2, 'DNI', '50350303Z', '2011-03-05', 'CARLA', 'ACEBES MONTALVILLO', '2011-03-05', 'Femenino', 'FRANCIA', 'Facultad de Informática', 'FRANCIA', 'carlaceb@ucm.es', 'QWE135790', NULL, NULL, '$2y$10$vf0ChVxwOTyfaoe4KYsHpeX1ZU32o8FcFvwbs196F3V2808ssDc8q', 'usuario'),
(3, NULL, NULL, NULL, 'Alberto', NULL, NULL, NULL, NULL, NULL, NULL, 'alberto@ucm.es', NULL, NULL, NULL, '$2y$10$W3OBzjHWNiaKycPJWkXNCey7SbvoVw.8giJ.Mn9FLU22N9E01B70.', 'usuario');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
