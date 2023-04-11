-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Temps de generació: 08-03-2023 a les 20:30:26
-- Versió del servidor: 10.1.32-MariaDB
-- Versió de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `chess`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `movimiento`
--

CREATE TABLE `movimiento` (
  `num_movimiento` int(3) NOT NULL,
  `id_partida` int(9) NOT NULL,
  `id_jugador` varchar(30) NOT NULL,
  `movimiento` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de la taula `partida`
--

CREATE TABLE `partida` (
  `id_game` int(9) NOT NULL,
  `id_usuario_blancas` int(5) NOT NULL,
  `id_usuario_negras` int(5) NOT NULL,
  `tiempo_blancas` time NOT NULL DEFAULT '00:10:00',
  `tiempo_negras` time NOT NULL DEFAULT '00:10:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de la taula `usuario`
--

CREATE TABLE `usuario` (
  `user_id` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `elo` int(4) NOT NULL DEFAULT '800',
  `description` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT 'img/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`num_movimiento`),
  ADD KEY `id_partida` (`id_partida`) USING BTREE;

--
-- Índexs per a la taula `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_game`),
  ADD UNIQUE KEY `blanca` (`id_usuario_blancas`) USING BTREE,
  ADD UNIQUE KEY `negra` (`id_usuario_negras`) USING BTREE;

--
-- Índexs per a la taula `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `num_movimiento` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `partida`
--
ALTER TABLE `partida`
  MODIFY `id_game` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `usuario`
--
ALTER TABLE `usuario`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `movimiento_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id_game`);

--
-- Restriccions per a la taula `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_usuario_blancas`) REFERENCES `usuario` (`user_id`),
  ADD CONSTRAINT `partida_ibfk_2` FOREIGN KEY (`id_usuario_negras`) REFERENCES `usuario` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
