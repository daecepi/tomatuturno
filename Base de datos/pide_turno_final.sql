-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2016 a las 02:09:26
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pide_turno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_programas`
--

CREATE TABLE `estado_programas` (
  `codigo` varchar(3) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `programa` varchar(100) NOT NULL,
  `user` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `Comentarios` text NOT NULL,
  `turnos_disponibles` int(20) NOT NULL,
  `turnos_atendidos` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_programas`
--

INSERT INTO `estado_programas` (`codigo`, `estado`, `programa`, `user`, `pass`, `Comentarios`, `turnos_disponibles`, `turnos_atendidos`) VALUES
('011', 'activo', 'INGENIERIA DE ALIMENTOS', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('019', 'activo', 'QUIMICA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('020', 'activo', 'MATEMATICAS', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('021', 'activo', 'INGENIERIA CIVIL', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('022', 'activo', 'INGENIERIA DE SISTEMAS', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('023', 'activo', 'INGENIERIA QUIMICA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('024', 'activo', 'ADMINISTRACION DE EMPRESAS NOCTURNA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('039', 'activo', 'COMUNICACION SOCIAL', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('041', 'activo', 'DERECHO', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('042', 'activo', 'TRABAJO SOCIAL', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('043', 'activo', 'ECONOMIA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('044', 'activo', 'ADMINISTRACION DE EMPRESAS DIURNA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('045', 'activo', 'CONTADURIA PUBLICA NOCTURNA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('046', 'activo', 'FILOSOFIA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('047', 'activo', 'LINGUISTICA Y LITERATURA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('048', 'activo', 'HISTORIA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('049', 'activo', 'ADMINISTRACION INDUSTRIAL', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('050', 'activo', 'CONTADURIA PUBLICA DIURNA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('051', 'activo', 'MEDICINA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('052', 'activo', 'ODONTOLOGIA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('053', 'activo', 'QUIMICA FARMACEUTICA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('054', 'activo', 'ENFERMERIA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('662', 'activo', 'BIOLOGIA', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('687', 'activo', 'TECNICA PROFESIONAL EN OPERACION DE PROCESOS PETROQUIMICOS', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('688', 'activo', 'LICENCIATURA EN EDUCACIÓN CON ENFASIS EN CIENCIAS SOCIALES Y AMBIENTALES', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('697', 'activo', 'TECNICA PROFESIONAL EN PROCESOS METROLOGICOS', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0),
('727', 'activo', 'PROFESIONAL UNIVERSITARIO EN LENGUAS EXTRANJERAS', 'admin', 'dullyeah', 'disponible: en todo momento', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `carrera` varchar(3) NOT NULL,
  `email` varchar(40) NOT NULL,
  `clave` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`codigo`, `nombre`, `carrera`, `email`, `clave`) VALUES
(343, 'Dani', '022', 'sdsds', 'sdf34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estado_programas`
--
ALTER TABLE `estado_programas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
