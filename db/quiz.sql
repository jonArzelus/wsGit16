-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2016 a las 22:18:29
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `erabiltzaileak`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quiz`
--

CREATE TABLE `quiz` (
  `galderaZenbakia` int(11) NOT NULL,
  `egilePosta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `galderaTestua` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `erantzunTestua` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zailtasuna` set('1','2','3','4','5') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `quiz`
--

INSERT INTO `quiz` (`galderaZenbakia`, `egilePosta`, `galderaTestua`, `erantzunTestua`, `zailtasuna`) VALUES
(1, 'a000@ikasle.ehu.eus', 'Zer da hau', 'Galdera bat', '1'),
(2, 'a000@ikasle.ehu.eus', 'Zer hostias habil lanean ordu hauetan', 'ez dakit', '5');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`galderaZenbakia`),
  ADD KEY `egilePosta` (`egilePosta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `quiz`
--
ALTER TABLE `quiz`
  MODIFY `galderaZenbakia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
