-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generaci�n: 08-04-2017 a las 03:57:30
-- Versi�n del servidor: 10.1.19-MariaDB
-- Versi�n de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

--
-- Base de datos: `simet_laboratorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itempropuesta`
--

CREATE TABLE `itempropuesta` (
  `itemPropuesta` int(2) NOT NULL,
  `subItem` int(2) NOT NULL,
  `titSubItem` varchar(50) NOT NULL,
  `descripcionSubItem` text NOT NULL,
  `Ensayos` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `itempropuesta`
--

INSERT INTO `itempropuesta` (`itemPropuesta`, `subItem`, `titSubItem`, `descripcionSubItem`, `Ensayos`) VALUES
(2, 1, 'Estudio de Antecedentes:', 'La caracterizaci�n y/o an�lisis se har� bas�ndose con los antecedentes entregados por el cliente, previo al inicio del trabajo. Adem�s contempla visitas a terreno, la cual debe estar establecida previamente entre las partes antes de iniciar el trabajo en cuesti�n.', ''),
(2, 2, 'Inspecci�n Visual:', 'Se inspeccionara la(s) pieza(s), realizando un levantamiento general y de detalles, los resultados resguardados en im�genes digitales. Adem�s se planificar�, de ser necesario, los cortes para la extracci�n de muestras.', ''),
(2, 3, 'Ensayos de laboratorio:', 'Los ensayos estimados para el cumplimiento de los objetivos es el siguiente:', 'on'),
(2, 4, 'Discusi�n de Resultados y Confecci�n de Informe:', 'Se realizara un informe t�cnico que considere el cumplimiento del objetivo propuesto.', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
