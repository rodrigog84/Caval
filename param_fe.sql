-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u2
-- http://www.phpmyadmin.net
--
-- Servidor: minotauro.agricultorestalca.cl
-- Tiempo de generación: 26-07-2016 a las 17:04:41
-- Versión del servidor: 5.5.46
-- Versión de PHP: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `deik`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_fe`
--

CREATE TABLE IF NOT EXISTS `param_fe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `param_fe`
--

INSERT INTO `param_fe` (`id`, `nombre`, `valor`) VALUES
(1, 'cert_password', '5490jorge'),
(2, 'rut_empresa', '76019353-4'),
(3, 'cert_password_encrypt', 'f82788a24a1193845c54f28131f99963'),
(4, 'envio_sii', 'manual'),
(5, 'tabla_contribuyentes', 'contribuyentes_autorizados_2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
