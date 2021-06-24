-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2021 a las 05:19:22
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `indegwgj_db_daniapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `PKCAT_ID` int(11) NOT NULL,
  `CAT_NOMBRE` varchar(60) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_categoria`
--

INSERT INTO `tbl_categoria` (`PKCAT_ID`, `CAT_NOMBRE`) VALUES
(13, 'ejemplo de cate1'),
(14, 'catejemplo 1'),
(15, 'Procesos internauticos'),
(16, 'Pansensuales'),
(17, 'Phva pic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_subcategoria`
--

CREATE TABLE `tbl_subcategoria` (
  `PKSUB_ID` int(11) NOT NULL,
  `FKCAT_ID` int(11) NOT NULL,
  `SUB_NOMBRE` varchar(60) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_subcategoria`
--

INSERT INTO `tbl_subcategoria` (`PKSUB_ID`, `FKCAT_ID`, `SUB_NOMBRE`) VALUES
(8, 13, 'ejemplo de subcate1'),
(9, 14, 'subejemplo 1'),
(10, 14, 'a ver que pasa'),
(12, 15, 'Interpolación de cadenas concatenadas'),
(13, 15, 'Maravillas modernas de los servidores publicos'),
(14, 16, 'Amo el pan'),
(15, 16, 'Amo la mogolla'),
(16, 17, 'Contratación'),
(17, 17, 'Seguimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tarea`
--

CREATE TABLE `tbl_tarea` (
  `PKTAR_ID` int(11) NOT NULL,
  `FKUSU_ID` int(11) NOT NULL,
  `FKSUB_ID` int(11) NOT NULL,
  `TAR_DESCRIPCION` varchar(1000) COLLATE utf8_spanish2_ci NOT NULL,
  `TAR_FECHA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_tarea`
--

INSERT INTO `tbl_tarea` (`PKTAR_ID`, `FKUSU_ID`, `FKSUB_ID`, `TAR_DESCRIPCION`, `TAR_FECHA`) VALUES
(16, 2, 12, 'Esta tarea es muy macabra', '2021-05-26 11:23:46'),
(17, 2, 13, 'Aquí inserto el texto de la tarea\r\nbla bla bla', '2021-05-28 12:21:48'),
(18, 2, 14, 'Esta descripción está super detallada ya que presenta sinopsis sinapticas en las mamalasticas', '2021-05-26 12:31:52'),
(19, 2, 14, 'Otra tarea dista mondá', '2021-05-28 12:40:21'),
(20, 2, 13, 'Esta será la sexta tarea', '2021-05-26 17:34:19'),
(21, 2, 15, 'Tarea super genérica', '2021-05-28 09:27:10'),
(27, 2, 8, 'recontramamabuebo bazo', '2021-05-31 23:07:30'),
(28, 2, 14, 'BASADO recontramamabuebo', '2021-05-31 23:08:01'),
(30, 2, 16, 'se realizó el documento', '2021-06-02 21:05:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `PKUSU_ID` int(11) NOT NULL,
  `USU_NOMBRE` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `USU_CORREO` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `USU_CONTRASENA` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `USU_SESION` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`PKUSU_ID`, `USU_NOMBRE`, `USU_CORREO`, `USU_CONTRASENA`, `USU_SESION`) VALUES
(2, 'dani', 'danny.lobsa@gmail.co', 'ZFFrQmhGYlM4T2ZtK042L0RINHN1Zz09', 0),
(3, 'nani', 'nani@gmail.com', 'ZFFrQmhGYlM4T2ZtK042', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`PKCAT_ID`);

--
-- Indices de la tabla `tbl_subcategoria`
--
ALTER TABLE `tbl_subcategoria`
  ADD PRIMARY KEY (`PKSUB_ID`),
  ADD KEY `fk_tblsubcategoria_tblcategoria` (`FKCAT_ID`);

--
-- Indices de la tabla `tbl_tarea`
--
ALTER TABLE `tbl_tarea`
  ADD PRIMARY KEY (`PKTAR_ID`),
  ADD KEY `fk_tbltarea_tblusuario` (`FKUSU_ID`),
  ADD KEY `fk_tbltarea_tblsubcategoria` (`FKSUB_ID`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`PKUSU_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `PKCAT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_subcategoria`
--
ALTER TABLE `tbl_subcategoria`
  MODIFY `PKSUB_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_tarea`
--
ALTER TABLE `tbl_tarea`
  MODIFY `PKTAR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `PKUSU_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_subcategoria`
--
ALTER TABLE `tbl_subcategoria`
  ADD CONSTRAINT `fk_tblsubcategoria_tblcategoria` FOREIGN KEY (`FKCAT_ID`) REFERENCES `tbl_categoria` (`PKCAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_tarea`
--
ALTER TABLE `tbl_tarea`
  ADD CONSTRAINT `fk_tbltarea_tblsubcategoria` FOREIGN KEY (`FKSUB_ID`) REFERENCES `tbl_subcategoria` (`PKSUB_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbltarea_tblusuario` FOREIGN KEY (`FKUSU_ID`) REFERENCES `tbl_usuario` (`PKUSU_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
