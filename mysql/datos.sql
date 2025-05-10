-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2025 a las 12:52:49
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
--
-- Volcado de datos para la tabla `contrataciones`
--
INSERT INTO `contrataciones` (
        `id_contratacion`,
        `id_reserva`,
        `id_servicio`,
        `cantidad`
    )
VALUES (2, 1, 1, 1),
    (3, 1, 2, 1),
    (4, 1, 8, 1),
    (5, 1, 8, 1),
    (6, 1, 8, 1),
    (15, 2, 1, 1);
--
-- Volcado de datos para la tabla `reservas`
--
INSERT INTO `reservas` (
        `id_reserva`,
        `fecha_entrada`,
        `fecha_salida`,
        `estado`,
        `usuarios_ids`
    )
VALUES (
        1,
        '2025-03-04',
        '2025-03-18',
        'confirmada',
        '[1]'
    ),
    (
        2,
        '2025-04-01',
        '2025-04-04',
        'pendiente',
        '[1, 2]'
    );
--
-- Volcado de datos para la tabla `servicios`
--
INSERT INTO `servicios` (`id_servicio`, `nombre`, `descripcion`, `precio`)
VALUES (
        1,
        'Desayuno buffet',
        'Acceso diario al desayuno buffet del hotel',
        12.50
    ),
    (
        2,
        'Spa y wellness',
        'Entrada al circuito de spa y centro de bienestar',
        25.00
    ),
    (
        3,
        'Limpieza extra',
        'Servicio adicional de limpieza de la habitación',
        10.00
    ),
    (
        4,
        'Servicio de lavandería',
        'Lavado y planchado de ropa personal',
        15.00
    ),
    (
        5,
        'Traslado al aeropuerto',
        'Transporte privado desde o hacia el aeropuerto',
        30.00
    ),
    (
        6,
        'WiFi premium',
        'Acceso a internet de alta velocidad durante toda la estancia',
        5.00
    ),
    (
        7,
        'Parking privado',
        'Estacionamiento en el parking privado del hotel',
        8.00
    ),
    (
        8,
        'Alquiler de bicicleta',
        'Alquiler diario de bicicletas del hotel',
        7.50
    ),
    (
        9,
        'Cuna para bebé',
        'Instalación de cuna en la habitación',
        0.00
    ),
    (
        10,
        'Late check-out',
        'Salida extendida hasta las 16:00 horas',
        20.00
    );
--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (
        `id_usuario`,
        `tipo_documento`,
        `numero_documento`,
        `fecha_expedicion`,
        `nombre`,
        `apellidos`,
        `fecha_nacimiento`,
        `sexo`,
        `nacionalidad`,
        `direccion`,
        `pais`,
        `correo`,
        `num_soporte`,
        `relacion_parentesco`,
        `edad`,
        `password_hash`,
        `rol`
    )
VALUES (
        1,
        'DNI',
        '02791496D',
        '2022-08-20',
        'JAVIER',
        'DE LA FUENTE DIEZ GARCIA',
        '2003-06-17',
        'Femenino',
        'ESPAÑA',
        'Facultad de Informática',
        'ESPAÑA',
        'dadela03@ucm.es',
        'ABC123456',
        NULL,
        NULL,
        '$2y$10$UU7B6Ru2JOY4DyM2s58zceO468nLOAi2dTwCCgRFhXMDIHbZSUt5m',
        'usuario'
    ),
    (
        2,
        'DNI',
        '50350303Z',
        '2014-11-13',
        'CARLA',
        'ACEBES MONTALVILLO',
        '2012-06-17',
        'Masculino',
        'FRANCIA',
        'Facultad de Informática',
        'FRANCIA',
        'carlaceb@ucm.es',
        'QWE135790',
        NULL,
        NULL,
        '$2y$10$vf0ChVxwOTyfaoe4KYsHpeX1ZU32o8FcFvwbs196F3V2808ssDc8q',
        'usuario'
    ),
    (
        3,
        NULL,
        NULL,
        NULL,
        'Alberto',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'alberto@ucm.es',
        NULL,
        NULL,
        NULL,
        '$2y$10$W3OBzjHWNiaKycPJWkXNCey7SbvoVw.8giJ.Mn9FLU22N9E01B70.',
        'admin'
    ),
    (
        4,
        NULL,
        NULL,
        NULL,
        'jesus',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'jesus@ucm.es',
        NULL,
        NULL,
        NULL,
        '$2y$10$.DOf3foekLW3oGRMP1SrPO/UqIZhb5rWfXXSz.h.b6dlh/8piRlxO',
        'usuario'
    );
--
-- Volcado de datos para la tabla `valoraciones`
--
INSERT INTO `valoraciones` (
        `id_valoracion`,
        `id_usuario`,
        `id_reserva`,
        `comentario`,
        `puntuacion`
    )
VALUES (4, 1, 1, 'Hola', 4);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;