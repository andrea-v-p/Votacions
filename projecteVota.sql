-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Temps de generació: 15-12-2017 a les 19:24:41
-- Versió del servidor: 5.7.20-0ubuntu0.16.04.1
-- Versió de PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `projecteVota`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `Invitacion`
--

CREATE TABLE `Invitacion` (
  `ID_Pregunta` int(3) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `Invitacion`
--

INSERT INTO `Invitacion` (`ID_Pregunta`, `Email`) VALUES
(1, 'user@user.com'),
(2, 'user@user.com');

-- --------------------------------------------------------

--
-- Estructura de la taula `Pregunta`
--

CREATE TABLE `Pregunta` (
  `ID` int(3) NOT NULL,
  `Pregunta` varchar(200) NOT NULL,
  `ID_Usuario` int(3) NOT NULL,
  `DataInici` date NOT NULL,
  `DataFinal` date NOT NULL,
  `HoraInicio` time(5) NOT NULL,
  `HoraFinal` time(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `Pregunta`
--

INSERT INTO `Pregunta` (`ID`, `Pregunta`, `ID_Usuario`, `DataInici`, `DataFinal`, `HoraInicio`, `HoraFinal`) VALUES
(1, 'hola', 1, '2017-11-30', '2017-12-04', '00:00:00.00000', '00:00:00.00000'),
(2, 'adios', 1, '2017-12-30', '2018-01-04', '00:00:00.00000', '00:00:00.00000');

-- --------------------------------------------------------

--
-- Estructura de la taula `relacionusuariovota`
--

CREATE TABLE `relacionusuariovota` (
  `ID_Usuario` int(3) NOT NULL,
  `ID_Pregunta` int(3) NOT NULL,
  `hash_enc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `relacionusuariovota`
--

INSERT INTO `relacionusuariovota` (`ID_Usuario`, `ID_Pregunta`, `hash_enc`) VALUES
(2, 1, 'KvpTAy'),
(2, 2, 'YKQP49');

-- --------------------------------------------------------

--
-- Estructura de la taula `Respuestas`
--

CREATE TABLE `Respuestas` (
  `ID_Respuesta` int(3) NOT NULL,
  `ID_Pregunta` int(3) NOT NULL,
  `Respuesta` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `Respuestas`
--

INSERT INTO `Respuestas` (`ID_Respuesta`, `ID_Pregunta`, `Respuesta`) VALUES
(1, 1, 'hola'),
(2, 1, 'que va'),
(3, 2, 'no se'),
(4, 2, 'si'),
(5, 2, 'no');

-- --------------------------------------------------------

--
-- Estructura de la taula `Usuarios`
--

CREATE TABLE `Usuarios` (
  `ID` int(3) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `Nombre`, `Email`, `Password`, `Admin`) VALUES
(1, 'prueba', 'prueba@prueba.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1),
(2, 'user1', 'user@user.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 0),
(3, 'user2', 'user2@user2.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 0),
(4, 'user3', 'user3@user.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 0),
(5, 'user4', 'user4@user.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `Votaciones`
--

CREATE TABLE `Votaciones` (
  `hash` varchar(500) NOT NULL,
  `ID_Respuesta` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `Votaciones`
--

INSERT INTO `Votaciones` (`hash`, `ID_Respuesta`) VALUES
('KvpTAy', 1),
('YKQP49', 5);

--
-- Indexos per taules bolcades
--

--
-- Index de la taula `Invitacion`
--
ALTER TABLE `Invitacion`
  ADD PRIMARY KEY (`ID_Pregunta`,`Email`),
  ADD KEY `email` (`Email`);

--
-- Index de la taula `Pregunta`
--
ALTER TABLE `Pregunta`
  ADD PRIMARY KEY (`ID`);

--
-- Index de la taula `relacionusuariovota`
--
ALTER TABLE `relacionusuariovota`
  ADD PRIMARY KEY (`hash_enc`);

--
-- Index de la taula `Respuestas`
--
ALTER TABLE `Respuestas`
  ADD PRIMARY KEY (`ID_Respuesta`);

--
-- Index de la taula `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Index de la taula `Votaciones`
--
ALTER TABLE `Votaciones`
  ADD PRIMARY KEY (`hash`),
  ADD UNIQUE KEY `hash` (`hash`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `Pregunta`
--
ALTER TABLE `Pregunta`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la taula `Respuestas`
--
ALTER TABLE `Respuestas`
  MODIFY `ID_Respuesta` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT per la taula `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Restriccions per taules bolcades
--

--
-- Restriccions per la taula `Invitacion`
--
ALTER TABLE `Invitacion`
  ADD CONSTRAINT `email` FOREIGN KEY (`Email`) REFERENCES `Usuarios` (`Email`),
  ADD CONSTRAINT `pregunta` FOREIGN KEY (`ID_Pregunta`) REFERENCES `Pregunta` (`ID`);

--
-- Restriccions per la taula `Votaciones`
--
ALTER TABLE `Votaciones`
  ADD CONSTRAINT `Votaciones_ibfk_1` FOREIGN KEY (`hash`) REFERENCES `relacionusuariovota` (`hash_enc`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
