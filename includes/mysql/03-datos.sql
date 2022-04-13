-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2022 a las 11:34:21
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

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

--
-- Volcado de datos para la tabla `episodios`
--

INSERT INTO `episodios` (`id_episodio`, `id_serie`, `titulo`, `duracion`, `temporada`, `ruta_video`, `sinopsis`) VALUES
(21, 5, 'aaaaaaaaaa', 22, 1, './img/episodios/videogenerico.mp4', 'aaaaaaaaaaaa'),
(23, 5, 'cccccc', 55, 1, './img/episodios/videogenerico.mp4', 'ccccccccccccc');

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `subtitulo`, `imagenNombre`, `contenido`, `fechaPublicacion`, `autor`, `categoria`, `etiquetas`) VALUES
(31, 'Alma coin y las virtudes de esta villana', 'La mala no tan mala', 'alma.jpg', 'La presidenta Coin aparece por primera vez en Sinsajo. Ella es la líder de la rebelión, y la presidenta del Distrito 13. Ella asume el poder después de que la rebelión termina. Katniss se da cuenta de su hambre de poder. Ella es muy egoísta, aunque trata de no parecerlo, como lo demuestra en numerosos actos en todo el libro. Algunos de estos actos incluyen ordenar el asesinato de Katniss, el bombardeo a los niños en el Capitolio lo que mata no sólo a los niños, sino también algunos médicos rebeldes, entre ellos Primrose Everdeen, y matando a una gran cantidad de gente innecesariamente. También es muy injusta, ya que iba a enjuiciar a Peeta Mellark, Johanna Mason y a Enobaria sólo por quedarse en la arena. Ella es aún más despiadada que el presidente Snow en muchos aspectos. Como venganza por los malos tratos a los distritos, ella sugiere en hacer los 76º Juegos del Hambre, pero en este caso los tributos serán tomados de los niños del capitolio. Estos juegos fueron votados por los vencedores, donde la mayoría decidió que había que hacerlos. Pero los juegos nunca se llevaron acabo por el asesinato de Coin. Ella fue asesinada por una flecha disparada por Katniss Everdeen (en parte para vengar la muerte de Primrose Everdeen) durante la ejecución del ex presidente de Panem, el presidente Snow. En Los Juegos del Hambre: Sinsajo - parte 1, Katniss pregunta a Prim por la escasez de niños, a lo que Prim responde que muchos de ellos murieron en una epidemia de varicela, incluyendo al esposo y a la hija de la presidenta Coin.', '2022-03-18', 'Mohammed', 'noticia', ''),
(32, 'Emma Watson estrena pel&iacute;cula en Fox', 'La maga novel se embarca en una nueva historia', 'emma.jpg', 'Ya ha visto la luz la primera imagen del nuevo filme de Emma Watson, Colonia. En el fotograma publicado por la productora Majestic Filmproduktion podemos ver a la actriz siendo intimidada por su compañero de reparto Mikael Nyqvist, actor de la trilogía Millenium.\r\nTambién se aprecia la ambientación de los años 70, ya que la película dirigida por el director Florian Gallenberger, quien ganó un Oscar por su cortometraje Quiero ser, cuenta la historia de una pareja de alemanes que son separados durante la dictadura de Pinochet en Chile. Cuando Daniel (Daniel Brühl, El hombre más buscado) es secuestrado, su esposa Lena (Watson) deberá unirse a una iglesia muy peligrosa para rescatarlo.\r\n\r\nEl equpo de Colonia acaba de terminar de rodar en Luxemburgo y ahora la producción se trasladará a Alemania antes de terminar en Sudamérica. Un largo camino hasta su estreno oficial programado para octubre de 2015.', '2022-03-18', 'Jie Gao', 'noticiaEstreno', ''),
(33, 'Kate Winslet sera la anfitriona de la inauguraci&oacute;n de DivergentPark', 'El nuevo parque que revolucionara Castilla y Leon', 'kate.jpg', 'Kate Elizabeth Winslet (CBE ) nació el 5 de octubre de 1975, en Reading, Inglaterra. Es una actriz británica de cine y cantante ocasional. En 2008 ganó el premio Óscar a la mejor actriz por su papel en The Reader, convirtiéndose en la actriz más joven en conseguir más nominaciones en dicho premio. Logró gran reconocimiento gracias a su participación en Sense and Sensibility en 1995, y la fama mundial por Titanic en 1997. Desde el año 2000, sus interpretaciones continuaron teniendo buenos comentarios de los críticos de cine, y ha sido nominada para varios premios por su trabajo en pelíclas como Quills (2000), Iris (2001), Eternal Sunshine of the Spotless Mind (2004), Finding Neverland (2004), Little Children (2006), The Reader (2008) y Revolutionary Road (2008). La revista New York la nombró como la \"mejor actriz anglo-parlante de su generación\".\r\n\r\nInterpreta a Jeanine Matthews en la adaptación de la novela Divergente escrita por Veronica Roth.', '2022-03-18', 'Sandra Sanchez', 'noticiaEvento', '');

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id_pelicula`, `titulo`, `director`, `duracion`, `genero`, `sinopsis`, `ruta_imagen`) VALUES
(17, 'Avatar', 'James Cameron', 162, 'ciencia ficcion', 'Jake Sully (Sam Worthington), un ex-marine condenado a vivir en una silla de ruedas, sigue siendo, a pesar de ello, un auténtico guerrero. Precisamente por ello ha sido designado para ir a Pandora, donde algunas empresas están extrayendo un mineral extraño que podría resolver la crisis energética de la Tierra. Para contrarrestar la toxicidad de la atmósfera de Pandora, se ha creado el programa Avatar, gracias al cual los seres humanos mantienen sus conciencias unidas a un avatar: un cuerpo biológico controlado de forma remota que puede sobrevivir en el aire letal. Esos cuerpos han sido creados con ADN humano, mezclado con ADN de los nativos de Pandora, los Na\'vi. Convertido en avatar, Jake puede caminar otra vez. Su misión consiste en infiltrarse entre los Na\'vi, que se han convertido en el mayor obstáculo para la extracción del mineral. Pero cuando Neytiri, una bella Na\'vi (Zoe Saldana), salva la vida de Jake, todo cambia: Jake, tras superar ciertas pruebas, es admitido en su clan. Mientras tanto, los hombres esperan los resultados de la misión de Jake', './img/pelis/avatar.png'),
(18, 'Titanic', 'James Cameron', 195, 'drama', 'Jack (DiCaprio), un joven artista, gana en una partida de cartas un pasaje para viajar a América en el Titanic, el transatlántico más grande y seguro jamás construido. A bordo conoce a Rose (Kate Winslet), una joven de una buena familia venida a menos que va a contraer un matrimonio de conveniencia con Cal (Billy Zane), un millonario engreído a quien sólo interesa el prestigioso apellido de su prometida. Jack y Rose se enamoran, pero el prometido y la madre de ella ponen todo tipo de trabas a su relación. Mientras, el gigantesco y lujoso transatlántico se aproxima hacia un inmenso iceberg.', './img/pelis/titanic.png'),
(19, 'El Castillo Ambulant', 'Hayao Miyazaki', 119, 'anime', 'Narra la historia de Sophie, una joven sobre la que pesa una horrible maldición que le confiere el aspecto de una anciana. Sophie decide pedir ayuda al mago Howl, que vive en un castillo ambulante, pero tal vez sea Howl quien necesite la ayuda de Sophie.', './img/pelis/castilloambulante.png'),
(20, 'El Padrino', 'Francis Ford Coppola', 175, 'drama', 'América, años 40. Don Vito Corleone (Marlon Brando) es el respetado y temido jefe de una de las cinco familias de la mafia de Nueva York. Tiene cuatro hijos: Connie (Talia Shire), el impulsivo Sonny (James Caan), el pusilánime Fredo (John Cazale) y Michael (Al Pacino), que no quiere saber nada de los negocios de su padre. Cuando Corleone, en contra de los consejos de \'Il consigliere\' Tom Hagen (Robert Duvall), se niega a participar en el negocio de las drogas, el jefe de otra banda ordena su asesinato. Empieza entonces una violenta y cruenta guerra entre las familias mafiosas.', './img/pelis/elpadrino.png'),
(21, 'El Exorcista', 'William Friedkin', 121, 'terror', 'Adaptación de la novela de William Peter Blatty que se inspiró en un exorcismo real ocurrido en Washington en 1949. Regan, una niña de doce años, es víctima de fenómenos paranormales como la levitación o la manifestación de una fuerza sobrehumana. Su madre, aterrorizada, tras someter a su hija a múltiples análisis médicos que no ofrecen ningún resultado, acude a un sacerdote con estudios de psiquiatría. Éste, convencido de que el mal no es físico sino espiritual, es decir que se trata de una posesión diabólica, decide practicar un exorcismo. Seguramente la película de terror más popular de todos los tiempos.', './img/pelis/exorcista.png'),
(22, 'Kimetsu no Yaiba: Mu', 'Haruo Sotozaki', 117, 'anime', 'Tanjiro Kamado y sus amigos del Demon Slayer Corps acompañan a Kyōjurō Rengoku, el Flame Hashira, para investigar una misteriosa serie de desapariciones que ocurren dentro de un tren aparentemente infinitamente largo. Poco saben que Enmu, la última de las Lunas Inferiores de los Doce Kizuki, también está a bordo y les ha preparado una trampa.', './img/pelis/kimetsu.png'),
(23, 'Logan', 'James Mangold', 135, 'accion', 'Sin sus poderes, por primera vez, Wolverine es verdaderamente vulnerable. Después de una vida de dolor y angustia, sin rumbo y perdido en el mundo donde los X-Men son leyenda, su mentor Charles Xavier lo convence para asumir una última misión: proteger a una joven que será la única esperanza para la raza mutante... Tercera y última película protagonizada por Hugh Jackman en el papel de Lobezno.', './img/pelis/logan.png'),
(24, 'Los Miserables', 'Tom Hooper', 152, 'musical', 'El expresidiario Jean Valjean (Hugh Jackman) es perseguido durante décadas por el despiadado policía Javert (Russell Crowe). Cuando Valjean decide hacerse cargo de Cosette, la pequeña hija de Fantine (Anne Hathaway), sus vidas cambiarán para siempre. Adaptación cinematográfica del famoso musical \'Les miserables\' de Claude-Michel Schönberg y Alain Boublil, basado a su vez en la novela homónima de Victor Hugo', './img/pelis/losmiserables.png'),
(25, 'Malefica', 'Robert Stromberg', 97, 'fantasia', 'Maléfica es una bella hada con un corazón puro y unas asombrosas alas negras. Crece en un entorno idílico, un apacible reino en el bosque limítrofe con el mundo de los hombres, hasta que un día un ejército de invasores humanos amenaza la armonía de su país. Maléfica se erige entonces en la protectora de su reino, pero un día es objeto de una despiadada e inesperada traición, un hecho triste y doloroso que endurecerá su corazón hasta convertirlo en piedra, y que la llevará a lanzar una temible maldición.', './img/pelis/malefica.png'),
(26, 'El Rito', 'Mikael H&aring;fstr&', 112, 'terror', 'Michael Kovak (Colin O\'Donoghue), un decepcionado seminarista norteamericano, decide asistir a un curso de exorcismos en el Vaticano, lo que hará que su fe se tambalee y tenga que enfrentarse a terribles fuerzas demoniacas. En Roma conocerá al Padre Lucas (Hopkins), un sacerdote poco ortodoxo que le enseñará el lado oscuro de la Fe.', './img/pelis/rito.png'),
(27, 'Mi vecino Totoro', 'Hayao Miyazaki', 86, 'anime', 'En los años 50, una familia japonesa se traslada al campo. Las dos hijas, Satsuki y Mei, entablan amistad con Totoro, un espíritu del bosque. El padre es un profesor universitario que estimula la imaginación de sus hijas relatándoles fábulas e historias mágicas sobre duendes, fantasmas y espíritus protectores de los hogares, mientras la madre se encuentra enferma en el hospital.', './img/pelis/totoro.png'),
(28, 'La tumba de las luci', 'Isao Takahata', 93, 'anime', 'Segunda Guerra Mundial (1939-1945). Seita y Setsuko son hijos de un oficial de la marina japonesa que viven en Kobe. Un día, durante un bombardeo, no consiguen llegar a tiempo al búnker donde su madre los espera. Cuando después buscan a su madre, la encuentran malherida en la escuela, que ha sido convertida en un hospital de urgencia.', './img/pelis/tumbaluciernagas.png'),
(39, 'La Tribu', 'Fernando Colomo', 90, 'comedia', 'Virginia (Carmen Machi), limpiadora de profesión y “streetdancer” vocacional, recupera al hijo que dio en adopción: Fidel (Paco León), un ejecutivo que lo ha perdido todo, incluida la memoria. Junto a “Las Mamis”, el extravagante grupo de baile que forman las compañeras de Virginia, madre e hijo descubrirán que a pesar de venir de mundos muy diferentes, ambos llevan el ritmo en la sangre.', './img/pelis/latribu.png');

--
-- Volcado de datos para la tabla `series`
--

INSERT INTO `series` (`id_serie`, `titulo`, `productor`, `numTemporadas`, `genero`, `sinopsis`, `ruta_imagen`) VALUES
(5, 'ggggggggggggggg', 'ggggggggggggggg', 2, 'accion', 'gggggggggggggggggggggggggg', './img/series/brujero.jpg');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nombreUsuario`, `nombre`, `apellido`, `password`, `rol_user`) VALUES
(6, 'Admin', 'Administrador', 'Administrador', '$2y$10$KggiRmk9OI39yyBdNJw48.FTfGkKVEJLoNgYrfWMf0k4RbTCRCnxC', 'admin'),
(7, 'Editor', 'Editor', 'Editor', '$2y$10$CKrc4uVMK8j9xikFAKG0FuxmnW9CCiBMSNICSKu9xPdC9Nowrw.9q', 'editor'),
(8, 'User1', 'Usuario', 'Usuario', '$2y$10$WNEu6ImVGgVr0tGzuDCsmuit20sQpmAHfgbFqXDxeAbUb5bk.BQj.', 'editor');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
