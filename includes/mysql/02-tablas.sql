-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: vm13.db.swarm.test
-- Tiempo de generación: 12-05-2022 a las 16:58:05
-- Versión del servidor: 10.8.2-MariaDB-1:10.8.2+maria~focal
-- Versión de PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `awfinity`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apariencia`
--

CREATE TABLE `apariencia` (
  `aspecto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bso`
--

CREATE TABLE `bso` (
  `id_bso` int(11) NOT NULL,
  `titulo` varchar(20) NOT NULL,
  `compositor` varchar(20) NOT NULL,
  `numCanciones` int(11) NOT NULL,
  `genero` enum('accion','anime','ciencia ficcion','comedia','drama','fantasia','musical','terror') NOT NULL,
  `sinopsis` text NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `id_cancion` int(11) NOT NULL,
  `id_bso` int(11) NOT NULL,
  `nombre_cancion` varchar(20) NOT NULL,
  `ruta_audio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `consulta` text NOT NULL,
  `motivo` enum('evaluacion','sugerencias','criticas') NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodios`
--

CREATE TABLE `episodios` (
  `id_episodio` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL,
  `titulo` varchar(20) NOT NULL,
  `duracion` int(11) NOT NULL,
  `temporada` int(11) NOT NULL,
  `ruta_video` varchar(525) NOT NULL,
  `sinopsis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(10) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `subtitulo` varchar(50) NOT NULL,
  `imagenNombre` varchar(50) NOT NULL,
  `contenido` text NOT NULL,
  `fechaPublicacion` date NOT NULL,
  `autor` varchar(20) NOT NULL,
  `categoria` enum('noticia','noticiaEvento','noticiaEstreno') NOT NULL,
  `etiquetas` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id_pelicula` int(10) NOT NULL,
  `titulo` varchar(20) NOT NULL,
  `director` varchar(20) NOT NULL,
  `duracion` int(10) NOT NULL,
  `genero` enum('accion','anime','ciencia ficcion','comedia','drama','fantasia','musical','terror') NOT NULL,
  `sinopsis` text NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliscompletado`
--

CREATE TABLE `peliscompletado` (
  `id_usuario` int(10) NOT NULL,
  `id_Reto` int(10) NOT NULL,
  `id_pelicula` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelisreto`
--

CREATE TABLE `pelisreto` (
  `id_Pelicula` int(10) NOT NULL,
  `id_Reto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retos`
--

CREATE TABLE `retos` (
  `id_Reto` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `num_usuarios` int(10) NOT NULL,
  `num_completado` int(10) NOT NULL,
  `dificultad` enum('DIFICIL','MEDIO','FACIL') NOT NULL,
  `descripcion` text NOT NULL,
  `dias` int(10) NOT NULL,
  `puntos` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE `series` (
  `id_serie` int(11) NOT NULL,
  `titulo` varchar(20) NOT NULL,
  `productor` varchar(20) NOT NULL,
  `numTemporadas` int(11) NOT NULL,
  `genero` enum('accion','anime','ciencia ficcion','comedia','drama','fantasia','musical','terror') NOT NULL,
  `sinopsis` text NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioreto`
--

CREATE TABLE `usuarioreto` (
  `id_usuario` int(10) NOT NULL,
  `id_Reto` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `completado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(10) NOT NULL,
  `nombreUsuario` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_user` enum('admin','editor','user','') NOT NULL,
  `puntos` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id_valoracion` int(11) NOT NULL,
  `idNoticia` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `puntuacion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apariencia`
--
ALTER TABLE `apariencia`
  ADD PRIMARY KEY (`aspecto`(50));

--
-- Indices de la tabla `bso`
--
ALTER TABLE `bso`
  ADD PRIMARY KEY (`id_bso`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`id_cancion`),
  ADD KEY `id_bso` (`id_bso`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Indices de la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD PRIMARY KEY (`id_episodio`),
  ADD KEY `id_serie` (`id_serie`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id_pelicula`),
  ADD KEY `titulo` (`titulo`);

--
-- Indices de la tabla `peliscompletado`
--
ALTER TABLE `peliscompletado`
  ADD PRIMARY KEY (`id_usuario`,`id_Reto`,`id_pelicula`),
  ADD KEY `id_usuario` (`id_usuario`,`id_Reto`,`id_pelicula`),
  ADD KEY `id_pelicula` (`id_pelicula`),
  ADD KEY `id_Reto` (`id_Reto`);

--
-- Indices de la tabla `pelisreto`
--
ALTER TABLE `pelisreto`
  ADD PRIMARY KEY (`id_Pelicula`,`id_Reto`),
  ADD UNIQUE KEY `id_Pelicula` (`id_Pelicula`,`id_Reto`),
  ADD KEY `id_Reto` (`id_Reto`);

--
-- Indices de la tabla `retos`
--
ALTER TABLE `retos`
  ADD PRIMARY KEY (`id_Reto`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id_serie`),
  ADD KEY `titulo` (`titulo`);

--
-- Indices de la tabla `usuarioreto`
--
ALTER TABLE `usuarioreto`
  ADD PRIMARY KEY (`id_usuario`,`id_Reto`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`id_Reto`),
  ADD KEY `id_Reto` (`id_Reto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `usuario` (`nombreUsuario`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `idNoticia` (`idNoticia`),
  ADD KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bso`
--
ALTER TABLE `bso`
  MODIFY `id_bso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `id_cancion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `episodios`
--
ALTER TABLE `episodios`
  MODIFY `id_episodio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id_pelicula` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `retos`
--
ALTER TABLE `retos`
  MODIFY `id_Reto` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `id_serie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`id_bso`) REFERENCES `bso` (`id_bso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD CONSTRAINT `episodios_ibfk_1` FOREIGN KEY (`id_serie`) REFERENCES `series` (`id_serie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `peliscompletado`
--
ALTER TABLE `peliscompletado`
  ADD CONSTRAINT `peliscompletado_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peliscompletado_ibfk_2` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id_pelicula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peliscompletado_ibfk_3` FOREIGN KEY (`id_Reto`) REFERENCES `retos` (`id_Reto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pelisreto`
--
ALTER TABLE `pelisreto`
  ADD CONSTRAINT `pelisreto_ibfk_1` FOREIGN KEY (`id_Reto`) REFERENCES `retos` (`id_Reto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pelisreto_ibfk_2` FOREIGN KEY (`id_Pelicula`) REFERENCES `peliculas` (`id_pelicula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarioreto`
--
ALTER TABLE `usuarioreto`
  ADD CONSTRAINT `usuarioreto_ibfk_1` FOREIGN KEY (`id_Reto`) REFERENCES `retos` (`id_Reto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioreto_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`idNoticia`) REFERENCES `noticias` (`idNoticia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valoraciones_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
