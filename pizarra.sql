-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2015 a las 13:26:08
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pizarra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE IF NOT EXISTS `clases` (
`id` int(11) NOT NULL,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_dominio` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `Nombre`, `id_dominio`, `created_at`, `updated_at`) VALUES
(1, 'Señales', 1, '2014-12-07 12:09:02', '0000-00-00 00:00:00'),
(2, 'Primeros Auxilios', 1, '2014-12-07 12:09:02', '0000-00-00 00:00:00'),
(3, 'Semáforos', 1, '2014-12-07 12:09:02', '0000-00-00 00:00:00'),
(4, 'Condensadores', 2, '2014-12-07 12:09:02', '0000-00-00 00:00:00'),
(5, 'Diodos', 2, '2014-12-08 07:10:42', '2014-12-08 07:10:42'),
(6, 'Corriente Alterna', 2, '2014-12-08 07:11:31', '2014-12-08 07:11:31'),
(7, 'Tejidos', 3, '2014-12-08 07:13:21', '2014-12-08 07:13:21'),
(9, 'Fibras', 3, '2014-12-08 07:15:20', '2014-12-08 07:15:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasexalumno`
--

CREATE TABLE IF NOT EXISTS `clasexalumno` (
  `idClase` bigint(20) unsigned NOT NULL,
  `idAlumno` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clasexalumno`
--

INSERT INTO `clasexalumno` (`idClase`, `idAlumno`) VALUES
(1, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominiopivot`
--

CREATE TABLE IF NOT EXISTS `dominiopivot` (
`id` int(11) unsigned NOT NULL,
  `id_dominio` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dominiopivot`
--

INSERT INTO `dominiopivot` (`id`, `id_dominio`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 2, 10, '2015-02-13 10:19:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominios`
--

CREATE TABLE IF NOT EXISTS `dominios` (
`id` int(11) NOT NULL,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `dominios`
--

INSERT INTO `dominios` (`id`, `Nombre`, `created_at`, `updated_at`) VALUES
(1, 'Seguridad Vial', '2014-12-07 11:42:51', '0000-00-00 00:00:00'),
(2, 'Electrónica', '2014-12-07 11:42:51', '0000-00-00 00:00:00'),
(3, 'Anatomía', '2014-12-07 11:42:51', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos`
--

CREATE TABLE IF NOT EXISTS `elementos` (
`id` int(11) unsigned NOT NULL,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `clase_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `fullname` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escenarios`
--

CREATE TABLE IF NOT EXISTS `escenarios` (
`id` int(11) unsigned NOT NULL,
  `clase_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `tipo` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `escenarios`
--

INSERT INTO `escenarios` (`id`, `clase_id`, `user_id`, `Nombre`, `fullname`, `Orden`, `tipo`, `created_at`, `updated_at`) VALUES
(3, 2, 7, 'fondo1', 'fondo1.jpg', 0, '', '2015-01-14 11:24:33', '2015-01-14 11:24:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escenarioximagen`
--

CREATE TABLE IF NOT EXISTS `escenarioximagen` (
`id` int(11) NOT NULL,
  `Id_Escenario` bigint(20) NOT NULL,
  `Id_imagen` bigint(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Volcado de datos para la tabla `escenarioximagen`
--

INSERT INTO `escenarioximagen` (`id`, `Id_Escenario`, `Id_imagen`) VALUES
(2, 1, 2),
(3, 1, 3),
(5, 1, 4),
(6, 1, 5),
(7, 1, 6),
(8, 1, 5),
(9, 1, 7),
(10, 1, 7),
(11, 1, 7),
(12, 1, 7),
(13, 1, 7),
(14, 1, 7),
(16, 1, 9),
(17, 1, 8),
(18, 1, 10),
(19, 1, 11),
(20, 1, 12),
(21, 1, 23),
(23, 1, 35),
(25, 2, 1),
(26, 2, 2),
(27, 2, 3),
(28, 2, 4),
(29, 2, 26),
(30, 2, 23),
(31, 2, 24),
(32, 3, 27),
(33, 3, 23),
(34, 3, 1),
(36, 2, 9),
(37, 1, 35),
(38, 3, 23),
(39, 3, 1),
(40, 3, 27),
(42, 1, 29),
(43, 1, 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE IF NOT EXISTS `materiales` (
`id` int(11) unsigned NOT NULL,
  `titulo` char(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `documento` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `desde` datetime NOT NULL,
  `hasta` datetime NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL,
  `time` char(9) COLLATE utf8_spanish_ci NOT NULL DEFAULT '00:00',
  `testype` int(10) unsigned NOT NULL,
  `examen` tinyint(1) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `titulo`, `descripcion`, `documento`, `desde`, `hasta`, `visible`, `time`, `testype`, `examen`, `created_at`, `updated_at`) VALUES
(8, 'Mirame el titulito', 'Como chorrea, como chorrea la superwoper cuando la aprietaaaas...', '', '2015-02-20 00:00:00', '2015-02-23 23:59:59', 1, '00:00', 0, 0, '2015-02-20 16:49:15', '2015-02-20 15:31:16'),
(10, 'Mirame el titulito', 'Como chorrea, como chorrea la superwoper cuando la aprietaaaas...', '', '2015-02-17 00:00:00', '2015-02-23 23:59:59', 0, '00:00', 0, 0, '2015-02-20 15:41:25', '2015-02-20 15:41:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materialespivot`
--

CREATE TABLE IF NOT EXISTS `materialespivot` (
`id` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `id_material` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE IF NOT EXISTS `preguntas` (
`id` int(11) unsigned NOT NULL,
  `pregunta` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `respuestas` tinyint(2) unsigned NOT NULL,
  `id_test` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE IF NOT EXISTS `respuestas` (
`id` int(11) unsigned NOT NULL,
  `respuesta` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_test` int(11) unsigned NOT NULL,
  `id_pregunta` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temarios`
--

CREATE TABLE IF NOT EXISTS `temarios` (
`id` bigint(20) NOT NULL,
  `idDominio` bigint(20) NOT NULL,
  `nombre` char(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `temarios`
--

INSERT INTO `temarios` (`id`, `idDominio`, `nombre`) VALUES
(1, 1, 'Señales de tráfico'),
(2, 1, 'Vehículos'),
(3, 2, 'Resistencias'),
(4, 2, 'Condensandores'),
(5, 3, 'Órganos'),
(6, 3, 'Huesos'),
(7, 1, 'Obligación'),
(8, 1, 'PRUEBA2'),
(9, 1, 'prueba'),
(10, 1, 'otra mas'),
(11, 1, 'a ver esta'),
(12, 1, 'familia nueva'),
(13, 1, 'familia nueva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
`id` int(11) unsigned NOT NULL,
  `titulo` char(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_clase` int(11) unsigned NOT NULL,
  `type` enum('0','1') COLLATE utf8_spanish_ci NOT NULL,
  `preguntas` tinyint(2) unsigned NOT NULL,
  `respuestas` tinyint(3) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `undoimages`
--

CREATE TABLE IF NOT EXISTS `undoimages` (
`id` int(11) unsigned NOT NULL,
  `dir` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `password` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `roles` enum('admin','alumno') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'alumno',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `firstname` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `phone` char(9) COLLATE utf8_unicode_ci NOT NULL DEFAULT '""',
  `remember_token` char(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nif` char(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `adress` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `locality` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `province` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `cp` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `borndate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `obs` char(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `enabled`, `password`, `last_login`, `roles`, `created_at`, `updated_at`, `firstname`, `lastname`, `phone`, `remember_token`, `nif`, `adress`, `locality`, `province`, `cp`, `borndate`, `obs`) VALUES
(7, 'Royer', 'papa@gmail.com', 1, '$2y$10$gzggzE5bwK7CnQPC3ScJ5u6PWHxgpLvFj.RoL9JK.zmGslo1BB6qK', '0000-00-00 00:00:00', 'alumno', '2015-01-15 18:19:03', '2015-01-15 17:19:03', 'Juan Carlos', 'Jenaro', '673215987', 'cWO1xRnnHUEfbfYneocEXkPfLmsXgvAty3VWfZynoUlCu0Mxt6ZULojToxlj', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(8, 'Andres', 'andresito@gmail.com', 1, '$2y$10$GkIFu39D5iziY5/72kW/KuLBEpzj4cm.KVziX9K7M5BX3w8Njjnz.', '0000-00-00 00:00:00', 'alumno', '2014-12-17 12:13:04', '2014-12-16 20:08:07', 'Andrés', 'Jenaro', '', NULL, '', '', '', '', '', '0000-00-00 00:00:00', ''),
(10, 'Prado', 'mdpcamacho@gmail.com', 1, '$2y$10$ogeyrkg6JeVceIapmu9sw.61nt.vAhqFI6LtBxfyKCfdOjX7lcZHC', '0000-00-00 00:00:00', 'alumno', '2015-02-13 09:14:08', '2015-02-06 10:03:53', 'María del Prado', 'Camacho Rojas', '', 'Zl2CIophbZm69fqKn8iVx0SrJ6gEWkbz5wl1nJfJttjSlyH4MnqM0cmnQpYy', '', '', '', '', '', '0000-00-00 00:00:00', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clasexalumno`
--
ALTER TABLE `clasexalumno`
 ADD PRIMARY KEY (`idClase`,`idAlumno`);

--
-- Indices de la tabla `dominiopivot`
--
ALTER TABLE `dominiopivot`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `dominios`
--
ALTER TABLE `dominios`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `elementos`
--
ALTER TABLE `elementos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `escenarios`
--
ALTER TABLE `escenarios`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `escenarioximagen`
--
ALTER TABLE `escenarioximagen`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materialespivot`
--
ALTER TABLE `materialespivot`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temarios`
--
ALTER TABLE `temarios`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tests`
--
ALTER TABLE `tests`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `undoimages`
--
ALTER TABLE `undoimages`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `dominiopivot`
--
ALTER TABLE `dominiopivot`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dominios`
--
ALTER TABLE `dominios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `elementos`
--
ALTER TABLE `elementos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `escenarios`
--
ALTER TABLE `escenarios`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `escenarioximagen`
--
ALTER TABLE `escenarioximagen`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `materialespivot`
--
ALTER TABLE `materialespivot`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `temarios`
--
ALTER TABLE `temarios`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `tests`
--
ALTER TABLE `tests`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `undoimages`
--
ALTER TABLE `undoimages`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
