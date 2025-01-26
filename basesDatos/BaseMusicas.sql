-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: db5015688180.hosting-data.io
-- Tiempo de generación: 15-01-2025 a las 18:24:17
-- Versión del servidor: 8.0.36
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs12803594`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_musica`
--

CREATE TABLE `archivos_musica` (
  `id` int NOT NULL,
  `DiscoID` int NOT NULL,
  `nombre_archivo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_audio` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos_musica`
--

INSERT INTO `archivos_musica` (`id`, `DiscoID`, `nombre_archivo`, `nombre_audio`) VALUES
(2, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 01 Introducción al Mundo de Mike.wav', 'Cebollita Macabra - Introducción al Mundo de Mike'),
(3, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 02 El Blues de la Cebollita.wav', 'Cebollita Macabra - El Blues de la Cebollita'),
(4, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 03 November Rain.wav', 'Cebollita Macabra - November Rain'),
(5, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 04 Festival.wav', 'Cebollita Macabra - Festival\r\n'),
(6, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 05 Interrupción.wav', 'Cebollita Macabra - Interrupción'),
(7, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 06 Narración Corta.wav', 'Cebollita Macabra - Narración Corta'),
(8, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 07 Estados de Euforia I.wav', 'Cebollita Macabra - Estados de Euforia I'),
(9, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 08 Púrpura.wav', 'Cebollita Macabra - Púrpura'),
(10, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 09 Estados de Euforia II.wav', 'Cebollita Macabra - Estados de Euforia II'),
(11, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 10 El Ataque de los Gordos Atómicos.wav', 'Cebollita Macabra - El Ataque de los Gordos Atómicos'),
(12, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 11 Domingo en el Velero.wav', 'Cebollita Macabra - Domingo en el Velero'),
(13, 2, 'Cebollita Macabra - ¿Fue Mike o el ataque de los gordos atómicos- - 12 Muerte en el Agujero.wav', 'Cebollita Macabra - Muerte en el Agujero.wav'),
(14, 3, 'CRIMES OFFICIAL - White Coffee - 04 White Coffee.wav', 'Cebollita Macabra - White Coffee.wav'),
(15, 4, 'CRIMES OFFICIAL - White Coffee - 01 Pharmakon.wav', 'Cebollita Macabra - Pharmakon'),
(16, 5, 'CRIMES OFFICIAL - White Coffee - 05 Black Circus.wav', 'Cebollita Macabra - Black Circus'),
(21, 10, ' Black Bird.wav', 'Delber Grady - Black Bird'),
(22, 10, 'Delber Grady - Black Bird - 02 Maggiepie.wav', 'Delber Grady - Maggiepie'),
(23, 10, 'Delber Grady - Black Bird - 03 Stay.wav', 'Delber Grady - Stay'),
(24, 10, 'Delber Grady - Black Bird - 04 No Es Verdad.wav', 'Delber Grady - No es Verdad'),
(25, 10, 'Delber Grady - Black Bird - 05 Goodbye.wav', 'Delber Grady - Goodbye'),
(26, 11, 'esta si hermano -tarde abril.wav', 'Muqui - Esta Tarde de Abril'),
(30, 15, 'Amsterdam.wav', 'Muqui - Amsterdam River'),
(32, 17, '07 Quiero Tender la Ropa.wav', 'La Ultranada - Quiero Tender la Ropa'),
(33, 17, '12 Soy un Artista.wav', 'La Ultranada - Bonus Track'),
(34, 17, '09 El Modo Ideal.wav', 'La Ultranada - El Modo Ideal'),
(35, 18, '10 Espiritu de Gato.wav', 'Tino Manzino - Perro Azul'),
(36, 19, '04 AMSTERDAM.wav', 'The Beatles - cancion1'),
(37, 20, '04 AMSTERDAM.wav', 'Cebollita Macabra - tete Fanta'),
(38, 21, '04 AMSTERDAM.wav', 'Cebollita Macabra - tete Fanta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Artistas`
--

CREATE TABLE `Artistas` (
  `ArtistaID` int NOT NULL,
  `UsuarioID` int DEFAULT NULL,
  `Nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Descripcion` text COLLATE utf8mb4_general_ci,
  `Pais` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Artistas`
--

INSERT INTO `Artistas` (`ArtistaID`, `UsuarioID`, `Nombre`, `Descripcion`, `Pais`) VALUES
(2, 2, 'Cebollita Macabra', 'Banda de funk-progresivo fundamental.', 'España'),
(3, 3, 'Delber Grady', 'Banda de rock progresivo de los 90.', 'England'),
(4, 4, 'Muqui', 'Proyecto personal del duque de platino espacial.', 'España'),
(7, 9, 'La Ultranada', 'Proyecto personal del musico madrileño Javi Romera, mezcla de electronica, loops y rock and roll.', 'España'),
(8, 10, 'Toni Manzino', 'Toni, peculiar personaje de la escena Sevillana de los 80.', 'Irlandad'),
(9, 11, 'Vado Permanente', 'grupo de versiones maomeno', 'España'),
(10, 13, 'Melange', 'Banda de Pop electrónico que conquisto el ultimo festival de verano en Benidorm.', 'España'),
(14, 18, 'Led Zeppelin', 'Banda de hard-rock emblematica, perteneciente a la decada de los 70.', 'England'),
(15, 19, 'La Ultranada', 'La forma y el vacío no son dos.', 'España'),
(16, 20, 'Cuervo Negro', 'Nada', 'Peru'),
(21, 30, 'Tata manana', 'Esto es manteca', 'Irlandad'),
(22, 32, 'ARDE', 'ARDE, anteriormente digestión, somos un grupo de punk con sede en Vallekas. \r\n\r\nJuntas desde 2018, nuestro recorrido ha sido sobre todo en locales y Centros Sociales, priorizando la escena frente al estudio. \r\n\r\nEn 2021 grabamos nuestra maketa \"S/T\" en los maravillosos Estudios La Nota. \r\n\r\nRecuerda ¡Préndele fuego a todo!  \r\n', 'VALLEKAS'),
(23, 33, 'Kintario', 'Rap a muerte', 'españa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Canciones`
--

CREATE TABLE `Canciones` (
  `CancionID` int NOT NULL,
  `DiscoID` int DEFAULT NULL,
  `Titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Duracion` time DEFAULT NULL,
  `NumeroTrack` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Canciones`
--

INSERT INTO `Canciones` (`CancionID`, `DiscoID`, `Titulo`, `Duracion`, `NumeroTrack`) VALUES
(2, 2, 'Introducción al Mundo de Mike', '04:59:00', NULL),
(3, 2, 'El Blues de la Cebollita', '04:53:00', NULL),
(4, 2, 'November Rain', '03:23:00', NULL),
(5, 2, 'Festival Atroz', '04:39:00', NULL),
(6, 2, 'Interrupción', '02:18:00', NULL),
(7, 2, 'Narración Corta', '04:35:00', NULL),
(8, 2, 'Estado de Euforia I', '07:24:00', NULL),
(9, 2, 'Purpura', '07:20:00', NULL),
(10, 2, 'Estado de Euforia II', '04:55:00', NULL),
(11, 2, 'El Ataque de los Gordos Atómicos', '06:46:00', NULL),
(12, 2, 'Domingo en el Velero', '04:20:00', NULL),
(13, 2, 'Muerte en el Agujero', '05:37:00', NULL),
(14, 3, 'White Coffee', '16:55:00', NULL),
(15, 4, 'Pharmakon', '14:19:00', NULL),
(21, 10, 'Black Bird', '09:41:00', NULL),
(22, 10, 'Maggiepie', '00:34:00', NULL),
(23, 10, 'Stay', '03:15:00', NULL),
(24, 10, 'No es Verdad', '02:07:00', NULL),
(25, 10, 'Goodbye', '03:09:00', NULL),
(26, 11, 'Esta Tarde de Abril', '03:51:00', NULL),
(30, 15, 'Amsterdam River', '04:12:00', NULL),
(32, 17, 'Quiero Tender la Ropa', '02:51:00', NULL),
(33, 17, 'Bonus Track', '02:51:00', NULL),
(34, 17, 'El Modo Ideal', '02:40:00', NULL),
(35, 18, 'Perro Azul', '02:20:00', NULL),
(37, 20, 'tete Fanta', '05:13:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Discos`
--

CREATE TABLE `Discos` (
  `DiscoID` int NOT NULL,
  `ArtistaID` int DEFAULT NULL,
  `Titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Genero` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `FechaLanzamiento` date DEFAULT NULL,
  `Creditos` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `InformacionDisco` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ImagenPortada` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Discos`
--

INSERT INTO `Discos` (`DiscoID`, `ArtistaID`, `Titulo`, `Genero`, `FechaLanzamiento`, `Creditos`, `InformacionDisco`, `ImagenPortada`) VALUES
(2, 2, '¿Fue Mike o el Ataque de los Gordos Atómicos?', 'Funk-Progresivo', '2010-03-10', NULL, NULL, 'Fue Mike o el Ataque de los Gordos Atmicos.jpg'),
(3, 2, 'White Coffee', 'Rock-Progresivo', '2011-03-10', NULL, NULL, '-Muerte.jpg'),
(4, 2, 'Pharmakon', 'Rock', '2011-03-10', NULL, NULL, '-Muerte.jpg'),
(10, 3, 'Black Bird', 'Rock-Progresivo', '2015-03-10', NULL, NULL, 'Delber Grady-Black Bird.jpg'),
(11, 4, 'Esta Tarde de Abril', 'Rock-Progresivo', '2024-11-30', NULL, NULL, 'Muqui-Esta Tarde de Abril.jpg'),
(15, 4, 'Amsterdam River', 'Rock-Progresivo', '1987-11-30', NULL, NULL, 'Muqui-Amsterdam River.jpg'),
(17, 7, 'Peliculas Raras', 'Rock', '2024-03-10', NULL, NULL, 'La Ultranada-Peliculas Raras.jpg'),
(18, 8, 'Perro Azul', 'Merengue', '1987-11-30', NULL, NULL, 'Tino Manzino-Perro Azul.jpg'),
(20, 2, 'Ferreteros Blancos', 'Rock', '2024-11-30', NULL, NULL, 'Cebollita Macabra-Ferreteros Blancos.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ListasReproduccion`
--

CREATE TABLE `ListasReproduccion` (
  `ListaID` int NOT NULL,
  `UsuarioID` int DEFAULT NULL,
  `NombreLista` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `FechaCreacion` date NOT NULL,
  `Publica` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lista_Canciones`
--

CREATE TABLE `Lista_Canciones` (
  `ListaID` int NOT NULL,
  `CancionID` int NOT NULL,
  `Orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordarme`
--

CREATE TABLE `recordarme` (
  `token` char(128) COLLATE utf8mb4_general_ci NOT NULL,
  `UsuarioID` int NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expira_en` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `UsuarioID` int NOT NULL,
  `NombreUsuario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Correo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ContraseñaHash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Rol` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `FechaCreacionPerfil` date DEFAULT NULL,
  `TokenRecuperacionContraseña` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`UsuarioID`, `NombreUsuario`, `Correo`, `ContraseñaHash`, `Rol`, `FechaCreacionPerfil`, `TokenRecuperacionContraseña`) VALUES
(2, 'Lucas', 'drfranky@hotmail.com', '$2y$10$yA0Il5Mdjt0Y2H2IeHYnJeXi9R2Q6ifheXtXXvX4y11jh4AhsyXVu', 'artista', '2024-05-02', NULL),
(3, 'Delber', 'drfranky@hotmail.com', '$2y$10$t1E/JoJ3vz9lvbpkx07C1e8c7WKVZda4tzew1APT.NuCxAfueueu.', 'artista', '2024-05-06', NULL),
(4, 'Muqui', 'drfranky@hotmail.com', '$2y$10$3/2LJhnvISs0yTDtOcDwpOzp1GDRzqEistlrGU/2Ue4eSG8gtjofi', 'artista', '2024-05-06', NULL),
(7, 'Maria', 'drfranky@hotmail.com', '$2y$10$v3Cr.qsSqxVhsCKH8AITz.w9mySFiBb/V7tZO9zPgPOoPaDCGWBlC', 'fan', '2024-05-28', NULL),
(8, 'Sara', 'drfranky@hotmail.com', '$2y$10$vbBd4RG/xVsYF2GppMMZ..zfoXyCOtggwS6Ousgx5neayUXqYNdTy', 'fan', '2024-05-29', NULL),
(9, 'Javi', 'drfranky@hotmail.com', '$2y$10$zF5TbHNoXmeagPEQJm.Wr.x.PI8IZx1.4J4rni/IC1mHDr0yOBZCK', 'artista', '2024-05-29', NULL),
(10, 'Toni', 'drfranky@hotmail.com', '$2y$10$NoR4oy/up1fKNEeS5Qm80uxBR7xdGPSbsu5O8y/0aVwWnM/FRtB7e', 'artista', '2024-05-30', NULL),
(11, 'vPerm', 'vperm@gmail.com', '$2y$10$geU7tFzz2llctH4dUCR7uu3xK9IIveKWu633GCU00kCU/pQ5wKNkK', 'artista', '2024-05-31', NULL),
(13, 'Angel', 'drfranky@hotmail.com', '$2y$10$Pj/FTehJqmRWc/3yMG9jbOnENTj4NKy2ijUB.WIVIblP8sEbDxVC.', 'artista', '2024-06-02', NULL),
(16, 'Sergio', 'o@o.com', '$2y$10$SGot/itxeAmCqecQmXciqOPlAvzeKIEsDkj8OjKIM9LSTTHs5HFIW', 'fan', '2024-06-11', NULL),
(18, 'Jimmy', 'drfranky@hotmail.com', '$2y$10$4xX0PLDaKiDfje.j1EzEQOMQez32rZLLsACLmLY6PTvJoGskhwWpK', 'artista', '2024-06-19', NULL),
(19, 'Donato', 'jajiromera@gmail.com', '$2y$10$YYDXBhSQlm.dmYK0E7hzbu/KD2TlERENdFJhCl.AgaMVbzzBR0klG', 'artista', '2024-06-19', NULL),
(20, 'Miguel', 'inigo.martin@abacodev.com', '$2y$10$yUAHk/ohcXUydHDTrc8vjuG1TYv8bO3ci1dnRb3kW7zwny4s0Tmt6', 'artista', '2024-06-20', NULL),
(28, 'Lucas1', 'drfranky@hotmail.com', '$2y$10$tOLoUkf3FuJStksB4t./7.sj6BrptrsAKYdpcb.VL/7ISf66Egpd2', 'fan', '2024-07-17', NULL),
(30, 'Nicolas', 'imartinllantada@gmail.com', '$2y$10$JcQWc58Y4I.wL58fQkCWT.clOTBtGE.2TQTWtRg1x29B0dQs7KQfe', 'artista', '2024-07-18', NULL),
(32, 'ARDE', 'ardepunk@gmail.com', '$2y$10$GEqOfu1SFI90gEmq9ISfueOTdKMYl8sDET02ZvPn56RypPYkJIvda', 'artista', '2024-07-19', NULL),
(33, 'Kintario', 'pepeone3@gmail.com', '$2y$10$dVF/5txEHFtCSlsDRNUE1.nJLDokxWR4KjTNEVK0m1Gs590iVOwVm', 'artista', '2024-07-19', NULL),
(35, 'Donatelo', 'imartinllantada@gmail.com', '$2y$10$ft1oaUO3uouLyvO/TS6wbujCc5LkXssWbEFb2tP.Zpr/4rc4xgmZK', 'fan', '2025-01-14', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_musica`
--
ALTER TABLE `archivos_musica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DiscoID` (`DiscoID`) USING BTREE;

--
-- Indices de la tabla `Artistas`
--
ALTER TABLE `Artistas`
  ADD PRIMARY KEY (`ArtistaID`),
  ADD KEY `UsuarioID` (`UsuarioID`);

--
-- Indices de la tabla `Canciones`
--
ALTER TABLE `Canciones`
  ADD PRIMARY KEY (`CancionID`),
  ADD KEY `DiscoID` (`DiscoID`);

--
-- Indices de la tabla `Discos`
--
ALTER TABLE `Discos`
  ADD PRIMARY KEY (`DiscoID`),
  ADD KEY `ArtistaID` (`ArtistaID`);

--
-- Indices de la tabla `ListasReproduccion`
--
ALTER TABLE `ListasReproduccion`
  ADD PRIMARY KEY (`ListaID`),
  ADD KEY `UsuarioID` (`UsuarioID`);

--
-- Indices de la tabla `Lista_Canciones`
--
ALTER TABLE `Lista_Canciones`
  ADD PRIMARY KEY (`ListaID`,`CancionID`),
  ADD KEY `CancionID` (`CancionID`);

--
-- Indices de la tabla `recordarme`
--
ALTER TABLE `recordarme`
  ADD PRIMARY KEY (`token`),
  ADD KEY `UsuarioID` (`UsuarioID`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`UsuarioID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos_musica`
--
ALTER TABLE `archivos_musica`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `Artistas`
--
ALTER TABLE `Artistas`
  MODIFY `ArtistaID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `Canciones`
--
ALTER TABLE `Canciones`
  MODIFY `CancionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `Discos`
--
ALTER TABLE `Discos`
  MODIFY `DiscoID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `ListasReproduccion`
--
ALTER TABLE `ListasReproduccion`
  MODIFY `ListaID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `UsuarioID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Artistas`
--
ALTER TABLE `Artistas`
  ADD CONSTRAINT `artistas_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `Usuarios` (`UsuarioID`);

--
-- Filtros para la tabla `Canciones`
--
ALTER TABLE `Canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`DiscoID`) REFERENCES `Discos` (`DiscoID`);

--
-- Filtros para la tabla `Discos`
--
ALTER TABLE `Discos`
  ADD CONSTRAINT `discos_ibfk_1` FOREIGN KEY (`ArtistaID`) REFERENCES `Artistas` (`ArtistaID`);

--
-- Filtros para la tabla `ListasReproduccion`
--
ALTER TABLE `ListasReproduccion`
  ADD CONSTRAINT `listasreproduccion_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `Usuarios` (`UsuarioID`);

--
-- Filtros para la tabla `Lista_Canciones`
--
ALTER TABLE `Lista_Canciones`
  ADD CONSTRAINT `lista_canciones_ibfk_1` FOREIGN KEY (`ListaID`) REFERENCES `ListasReproduccion` (`ListaID`),
  ADD CONSTRAINT `lista_canciones_ibfk_2` FOREIGN KEY (`CancionID`) REFERENCES `Canciones` (`CancionID`);

--
-- Filtros para la tabla `recordarme`
--
ALTER TABLE `recordarme`
  ADD CONSTRAINT `recordarme_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `Usuarios` (`UsuarioID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
