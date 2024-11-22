-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generaci�n: 08-04-2017 a las 04:37:04
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
-- Estructura de tabla para la tabla `ofensayos`
--

CREATE TABLE `ofensayos` (
  `nDescEnsayo` int(2) NOT NULL,
  `idEnsayo` varchar(3) NOT NULL,
  `nomEnsayo` varchar(50) NOT NULL,
  `Descripcion` text NOT NULL,
  `Status` varchar(3) NOT NULL,
  `Generico` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ofensayos`
--

INSERT INTO `ofensayos` (`nDescEnsayo`, `idEnsayo`, `nomEnsayo`, `Descripcion`, `Status`, `Generico`) VALUES
(2, '', 'Ensayos no destructivos', 'Estos ensayos se pueden realizar mediante tintas, ultrasonido, part�culas magn�ticas, radiograf�as. La elecci�n del tipo de ensayo se realizar en virtud del cumplimiento del objetivo a menos que el mandante estime lo contrario, lo cual debe ser establecido previamente entre las partes.', 'on', 'on'),
(1, '', 'An�lisis Dimensional', 'Se realizar�n las mediciones necesarias, con los instrumentos indicados para la confirmaci�n o ratificaci�n de las medidas especificadas por normas, planos y/o especificaci�n del cliente.', 'on', 'on'),
(4, 'Qu', 'An�lisis Qu�mico', 'El an�lisis qu�mico de las muestra(s) de estudio es realizado por espectrometr�a de emisi�n �ptica (base Fe, Cu y Al), seg�n norma ASTM A571. En el caso que la muestra sea muy peque�a y/o  encontrase con un metal en otra base, se podr� hacer un ensayo de an�lisis semicuantitativo de elementos por microscopia electr�nica de barrido (EDS).', 'on', 'on'),
(3, '', 'Analisis Fractogr�fico', 'analizar� la superficie de la fractura de la o las piezas de estudios.', 'on', 'on'),
(10, '', 'Medici�n de Rugosidad Superficial', 'La rugosidad superficial, se podr�n determinar los par�metros Ra y/o  Rz, dependiendo de las caracter�sticas y necesidades del estudio, bas�ndose en la norma ASTM XXXX o alguna norma equivalente.', 'off', 'on'),
(5, '', 'Macrografias', 'Se requiere para el an�lisis realizar una macrograf�a para evaluar los sectores de interes observando posibles anomal�as en las muestras, este ensayo se basa en la norma ASTM E XXX.', 'off', 'on'),
(6, 'M', 'An�lisis Metalogr�fico', 'Se realizar�n los sectores de inter�s para el posterior an�lisis metalogr�fico, para poder analizar las microestructuras. La preparaci�n de las muestras se realiza mediante la norma ASTM E3 y la selecci�n del ataque qu�mico seg�n la norma ASTM E407.', 'off', 'on'),
(7, 'Tr', 'Ensayos Tracci�n', 'Los ensayos de tracci�n se realizaran en base a la norma ASTM E8, o equivalente dependiendo de los requerimientos (API, AWS, ASME, ASTMA 370, etc.).', 'off', 'on'),
(8, 'Do', 'Ensayos de Doblado', 'Los ensayos de doblado se realizaran seg�n norma que corresponda (API, AWS, ASME, ASTM, etc.).', 'off', 'on'),
(9, 'Du', 'Ensayos de Dureza', 'Dependiendo de la naturaleza del an�lisis, se podr�n realizara microdurezavickers(norma ASTM 999)o durezas de otros tipos, como Brinell (norma ASTM XXXX), Rockwell A, B, C, 30T, etc (norma ASTM XXXX), o Shor A (norma ASTM XXXX).', 'off', 'on'),
(11, 'S', 'Microscopia Electr�nica de Barrido', 'Se realizar� microscopia electr�nica para observar las zonas de inter�s y adem�s, si es necesario, se realizar�n cuantificaci�n de elementos por microsonda (EDS).', '', 'on'),
(12, '', 'Curvas de Polarizaci�n', 'Como resultado de este estudio, adem�s de determinar las curvas de polarizaci�n, se pueden determinar la corriente y potencial de corrosi�n en distintos medios, adem�s con los mismos datos es posible determinar la velocidad de corrosi�n en MPY, este ensayo se basa en la norma ASTM XXXX.', '', 'on'),
(13, '', 'Ensayo de C�mara de Niebla Salina', 'El ensayo esta normado bajo la norma ASTM B117, el cual puede ser modificado si el ensayo lo requiere, la cantidad de horas de exposici�n es de "...1000...".horas.', '', 'on'),
(15, '', 'Otros ensayos', 'Los ensayos adicionales a la realizar son los siguiente:', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
