
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nombreUsuario` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_user` enum('admin','editor','user','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nombreUsuario`, `nombre`, `apellido`, `password`, `rol_user`) VALUES
(6, 'Admin', 'Administrador', 'Administrador', '$2y$10$KggiRmk9OI39yyBdNJw48.FTfGkKVEJLoNgYrfWMf0k4RbTCRCnxC', 'admin'),
(7, 'Editor', 'Editor', 'Editor', '$2y$10$CKrc4uVMK8j9xikFAKG0FuxmnW9CCiBMSNICSKu9xPdC9Nowrw.9q', 'editor'),
(8, 'User1', 'Usuario', 'Usuario', '$2y$10$WNEu6ImVGgVr0tGzuDCsmuit20sQpmAHfgbFqXDxeAbUb5bk.BQj.', 'editor');
