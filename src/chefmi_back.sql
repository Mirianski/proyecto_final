-- MySQL dump 10.13  Distrib 8.0.20, for Linux (x86_64)
--
-- Host: localhost    Database: chefmi
-- ------------------------------------------------------
-- Server version	8.0.20-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etiquetas` (
  `id_etiqueta` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `imagen` text NOT NULL,
  PRIMARY KEY (`id_etiqueta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
INSERT INTO `etiquetas` VALUES (1,'Sin Gluten','sin_gluten.png'),(2,'Vegano','vegan.png'),(3,'Vegetariano','vegetariano.png'),(4,'Intolerante lactosa','sin_lactosa.png');
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etiquetas_platos`
--

DROP TABLE IF EXISTS `etiquetas_platos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etiquetas_platos` (
  `id_etiqueta` int NOT NULL,
  `id_plato` int NOT NULL,
  PRIMARY KEY (`id_etiqueta`,`id_plato`),
  KEY `id_plato` (`id_plato`),
  CONSTRAINT `etiquetas_platos_ibfk_1` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id_etiqueta`),
  CONSTRAINT `etiquetas_platos_ibfk_2` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas_platos`
--

LOCK TABLES `etiquetas_platos` WRITE;
/*!40000 ALTER TABLE `etiquetas_platos` DISABLE KEYS */;
INSERT INTO `etiquetas_platos` VALUES (1,1),(2,1),(3,1),(4,1),(1,2),(2,2),(3,2),(4,2),(1,6),(3,6),(4,6),(1,7),(3,7),(4,7),(1,8),(3,8),(1,9),(4,9),(2,10),(3,10),(4,10);
/*!40000 ALTER TABLE `etiquetas_platos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platos`
--

DROP TABLE IF EXISTS `platos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `platos` (
  `id_plato` int NOT NULL AUTO_INCREMENT,
  `id_tipo` int NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `ingredientes` text NOT NULL,
  `preparacion` text NOT NULL,
  `imagen` text,
  `dificultad` int NOT NULL,
  `tiempo` int NOT NULL,
  `num_personas` int NOT NULL,
  `estado` tinyint(1) DEFAULT '0',
  `votos` int DEFAULT '0',
  `autor` varchar(60) NOT NULL,
  PRIMARY KEY (`id_plato`),
  KEY `id_tipo` (`id_tipo`),
  CONSTRAINT `platos_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platos`
--

LOCK TABLES `platos` WRITE;
/*!40000 ALTER TABLE `platos` DISABLE KEYS */;
INSERT INTO `platos` VALUES (1,3,'Galletas tipo cookies (Sin azúcares añadidos)','¿A quién no se le antoja de vez en cuando un dulce pero no quiere romper su dieta o ingerir esos azúcares extra que tanto tememos? Estas galletitas caseras son fáciles y rápidas de hacer, y no llevan ningún tipo de azúcar añadido. Además, tiene opción apta para veganos y celiacos.','110 gramos de harina de avena o avena molida (Existe avena apta para celiacos)<br />\r\n50 ml. de leche (o cualquier bebida vegetal)<br />\r\n50 gr. de chocolate negro (puede ser vegano, o sin lactosa)<br />\r\n100 gr. de dátiles / 4 Cucharadas de pasta de dátiles (o 70 gr. aprox. de azucar)<br />\r\n1 Cucharada de aceite de oliva<br />\r\n1 Cucharadita de extracto de vainilla (opcional)','Lo primero de todo es hacer la pasta de dátiles en el caso de que te hayas decantado por una opción sin azúcares añadidos. Para ello cogeremos unos 100 gr de dátiles  (entre 15 y 20), les quitaremos el hueso en caso de que lo tengan y los meteremos en una procesadora con unos 100 ml de agua. Lo procesamos hasta que se convierta en una masa uniforme, que más adelante utilizaremos como endulzante.<br />\r\nPoner el horno a precalentar a 180º.<br />\r\nEn un bol vertemos 90 de los 110 gr. harina de avena, o la avena previamente molida en caso de tenerla granulada, unas 4 cucharadas de pasta de dátiles (aunque lo mejor es regular la cantidad según tus gustos), la leche vegetal, la cucharada de aceite de oliva y por último el extracto de vainilla.<br />\r\nMezclamos todo bien, y la masa quedará un poco húmeda y poco manipulable, así que en este punto le añadimos los 20 gr. de harina restante. <br />\r\nCortamos con un cuchillo los 50gr. de chocolate en pedazos muy pequeños, que pueda simular a los \"chips\" de las cookies. Se los añadimos a la masa y volvemos a mezclar.<br />\r\nEn nuestra bandeja de horno, pondremos papel vegetal para evitar que nuestras galletas se peguen y empezamos a darle forma a nuestras galletas, el tamaño dependerá de nuestros gustos, pero lo importante es que tengan el mismo tamaño para que se hagan todas por igual.<br />\r\nSe meten en el horno entre 15 y 20 minutos, según si se quieran más tiernas (15 min) o más crujientes (20 min).<br />\r\nSi se tiene una rejilla, lo ideal sería dejarlas reposar en ella para que el calor se disipe sin humedecer demasiado la galleta.<br />\r\n','Cookies sin azucares.png',2,30,1,1,4,'Chefmi'),(2,2,'Pasta de dátiles (Endulzante sustituto de azúcar)','La pasta de dátiles es el complemento perfecto para añadir dulzor a tus postres si no quieres usar azúcares refinados o azúcar moreno, si no que optas por algo más saludable.',' 100 gr. dátiles (15-20 dátiles)<br />\r\n100 ml. agua','Si tus dátiles tienen hueso, quítaselo y metelos en una procesadora o batidora. Añade el agua y ve batiendo hasta que salga una masa uniforme. Con estas cantidades puedes sustituir unos 100 gr. de azúcar. <br />\r\nPuedes preparar más cantidad y conservarla en un bote de cristal en la nevera y dura unos 4-5 días perfectamente.','Pasta de dátiles.jpg',1,5,1,1,0,'Chefmi'),(6,5,'Merluza al horno con patatas','La merluza es un pescado blanco, con un bajo contenido graso y de calorías, por lo que es muy recomendado para los que estéis con una dieta o con la socorrida “operación bikini”. Es rica en proteínas, vitaminas del tipo B y minerales como el magnesio, fósforo y potasio. Tiene pocas espinas, y éstas se retiran con facilidad, por lo que es perfecta para que la disfruten los más peques de la casa.',' 2 rodajas de merluza (300 gr. aprox)<br />\r\n2 o 3 patatas medianas<br />\r\nMedia cebolla pequeñita<br />\r\n1 diente de ajo<br />\r\n1/2 cucharada de perejil<br />\r\nAceite de oliva (para freír patatas y la merluza)<br />\r\nSal fina y gruesa','Le pediremos al pescadero que nos prepare la merluza para el horno, quitándole las vísceras y raspándole bien las escamas. La cabeza no la necesitamos esta vez, pero podéis guardarla (o congelarla) para hacer un caldo de pescado.<br />\r\nSi lo queréis hacer en casa, tendréis que lavarla, desescamarla, limpiarla y luego cortarla en rodajas de unos 2-2,5 cm. de grosor, dejando la parte final de la cola de una pieza.<br />\r\nUna vez separadas las porciones de merluza, le echamos sal gorda al gusto y dejamos que la vaya absorbiendo con calma, mientras preparamos el resto de la receta. De esta manera la carne del pescado nos quedará más firme y de mejor textura.<br />\r\nPelamos la cebolla y la cortamos en juliana. En una sartén, echamos una lámina de aceite de oliva y cuando coja temperatura añadimos la cebolla. Salamos ligeramente. Vamos a cocinarla a fuego medio durante 10 minutos, para que se vaya ablandando y nos quede medio hecha antes de meterla al horno. Reservamos.<br />\r\nLavamos y pelamos las patatas. Las cortamos en panadera, en rodajas finas de medio cm. Las ponemos a freír en aceite bien caliente, 10 minutos por lo menos, que nos queden también medio hechas. Retiramos y reservamos.<br />\r\nPonemos a precalentar el horno, 5 minutos a 200º C, en función  “calor total”, con el ventilador.<br />\r\nPelamos los ajos, les retiramos el germen del interior, y los picamos bien finitos. Picamos el perejil fresco bien fino. En un cuenco pequeño, echamos  5 cucharadas de aceite de oliva, el ajo y el perejil, y mezclamos bien todo. Esta mezcla la vamos a usar para aderezar la merluza.<br />\r\nEn una bandeja de horno plana y grande, comenzamos con el montaje del plato antes de hornear. Colocamos una base con la cebolla pochada, sobre ella las patatas panadera y finalmente los trozos de merluza.<br />\r\nSobre el pescado vertemos el aliño que tenemos preparado, de esta manera le daremos un toque de sabor y no se nos secará en el horno. Horneamos con calor arriba y abajo, 10-12 minutos a 180º C.<br />\r\nPara un grosor de los pedazos de unos 2 cm., con este tiempo es suficiente para que la merluza nos quede en su punto. No debemos “machacarla” mucho para poder disfrutar de su frescura y textura.<br />\r\n<br />\r\n','Merluza al horno.png',2,40,1,1,0,'Chefmi'),(7,1,'Pimientos del piquillo rellenos de atún','Los pimientos del piquillo rellenos de atún se preparan en menos de 15 minutos y resolverán muchas de vuestras cenas con amigos. ¡No os los perdáis!',' 8 pimientos del piquillo<br />\r\n2 latas de atún<br />\r\n1 huevo<br />\r\n1 cucharadita de sal<br />\r\n2 cucharadas soperas de tomate frito<br />\r\n150 ml. de leche (o bebida vegetal)<br />\r\n1 cucharada de aceite de oliva<br />\r\n2 cucharadas de harina  ','Reunimos todos los ingredientes para preparar los pimientos del piquillo rellenos de atún y bechamel. En esta ocasión hemos sustituido el atún por melva, pero también se puede utilizar bonito en conserva por ejemplo.<br />\r\nCocemos el huevo en abundante agua hirviendo durante 10 minutos.<br />\r\nPor otra parte, preparamos la salsa bechamel para que los pimientos del piquillo con atún estén más sabrosos: en una olla calentamos el aceite de oliva, añadimos la harina, mezclamos bien y vamos añadiendo la leche hasta que espese sin dejar de mover. No olvidéis añadir un poco de sal y si os gusta, nuez moscada molida.<br />\r\nUna vez cocido, pasamos el huevo por agua fría para que sea más fácil pelarlo. Lo pelamos y lo picamos en trozos pequeños.<br />\r\nEn un bol mezclamos el huevo con el atún desmigado.<br />\r\nAñadimos un poco de tomate frito, mezclamos y agregamos dos cucharadas soperas de salsa bechamel. Movemos bien para que se integren todos los ingredientes del relleno de los pimientos del piquillo.<br />\r\nRellenamos los pimientos del piquillo con el atún que hemos preparado. Hemos de tener cuidado de no romperlos ya que son muy delicados.<br />\r\nPara servir, ponemos un poco más de salsa bechamel sobre los pimientos del piquillo rellenos de atún y ¡listos para comer!<br />\r\n<br />\r\n<br />\r\n','Pimientos de piquillo rellenos.png',2,15,4,1,0,'Chefmi'),(8,3,'Tarta 3 chocolates','Tarta a los tres chocolates',' 150 gr. chocolate negro<br />\r\n150 gr. chocolate con leche<br />\r\n150 gr. chocolate blanco<br />\r\n150 gr. galletas tipo maría (pueden ser sin gluten)<br />\r\n75 gr. de mantequilla<br />\r\n600 ml nata para montar<br />\r\n900 ml leche<br />\r\n24 gr. (3 sobres) de cuajada','Triturar las galletas junto con la mantequilla. <br />\r\nForrar la base de un molde de 22 cm con papel de horno y añadir la preparación anterior. <br />\r\nAplanar con el dorso de una cuchara cubriendo toda la base del molde.<br />\r\nRefrigerar como mínimo media hora. <br />\r\nPoner a calentar en un cazo 200 ml de leche y 200 ml de nata. Añadir el chocolate negro y remover hasta fundir. <br />\r\nMezclar un sobre de cuajada con 100 ml de leche y remover bien para que no queden grumos.<br />\r\nAñadir la cuajada a la mezcla de chocolate y remover suavemente unos 5 minutos hasta que espese ligeramente. Verter sobre la base de galleta y dejar enfriar una media hora.<br />\r\nRayar la superficie de la capa de chocolate negro con un tenedor para ayudar a fijar la siguiente capa.<br />\r\nRepetir la misma operación con el chocolate con leche, vertiendo la mezcla sobre el dorso de una cuchara para que no se rompa la capa inferior, y dejar enfriar otros 30 minutos. Rayar de nuevo la superficie con un tenedor.<br />\r\nPor último repetir la operación con el chocolate blanco y dejar enfriar la tarta unas 4-5 horas antes de servir.','Tarta 3 chocolates.png',3,40,10,1,0,'Chefmi'),(9,4,'Pollo mechado','La carne mechada es tradicional de la gastronomía venezolana, la cual suele utilizarse como relleno de las deliciosas arepas pero también como principal ingrediente de muchos otros platos. Pues bien, además de la carne de res, también es posible preparar pollo mechado, este queda muchísimo más sabroso y puede ser un acompañamiento perfecto para el arroz, las patatas, los vegetales, etc. ',' 3 pechugas de pollo sin piel<br />\r\n1 cebolla(s) pequeña(s)<br />\r\n1 pimiento(s) rojo<br />\r\n4 dientes de ajo<br />\r\n2 cucharadas de salsa de tomate<br />\r\n1 cucharada de mostaza<br />\r\nSal al gusto<br />\r\nPimienta al gusto','Lo primero que tienes que hacer es poner agua a hervir en una olla, no la llenes demasiado para que no se desborde cuando pongas el pollo. Cuando el agua esté hirviendo, introduce las pechugas de pollo para que se cocinen. Pasados unos 30-40 minutos (dependiendo del tamaño de las pechugas), saca y deja que enfríen un poco.<br />\r\nMientras tanto, pica los vegetales y el ajo en trozos bien pequeños. Coloca una sartén en le fuego, calienta un poco de aceite y agrega los vegetales y el ajo. Añade un poco de sal y pimienta de una vez. Cocina 5 minutos a fuego medio removiendo de vez en cuando, puedes ir mechando el pollo mientras pasa el tiempo.<br />\r\nA continuación, debes agregar la salsa de soja, la salsa de tomate y la mostaza. Mezcla bien todos los ingredientes para que los sabores se vayan fusionando.<br />\r\nLuego, agrega el pollo mechado; si no está listo apaga los vegetales mientras lo haces. Mezcla bien y verás cómo todo empieza a coger color. Cocina de 5 a 7 minutos y prueba si tiene suficiente sal para añadir un poco más en caso de que sea necesario. ¡Así de fácil! Ahora ya tienes listo el pollo mechado para servir y acompañarlo con lo que quieras.<br />\r\n','pollo mechado.png',2,45,3,1,0,'Chefmi'),(10,6,'Lasaña de verduras','Lasaña de verduras (Apta para veganos!)','1 kg. de calabacín<br />\r\n1 kg. de berenjena<br />\r\n50 ml. de aceite de oliva<br />\r\n2 ajos<br />\r\nCebollino fresco<br />\r\n1 litro de leche vegetal (sin azúcar)<br />\r\n40 g. de harina blanca de trigo<br />\r\n3 cucharadas de aceite<br />\r\nSal al gusto<br />\r\nNuez moscada al gusto','Limpia el calabacín y la berenjena y córtalos en laminas. Para este paso, puedes utilizar una mandolina como ésta.<br />\r\nCalienta una sartén, añade un poco de aceite y empieza a dorar las láminas de berenjena por tandas. Repite el proceso, añadiendo de nuevo aceite en cada tanda hasta que tengas cocinada toda las láminas de berenjena.<br />\r\nCocina ahora el calabacín, siguiendo el procedimiento anterior.<br />\r\nPreparar la pasta de la lasaña según indique el fabricante.<br />\r\nMientras, prepara la bechamel. Pon a calentar la leche vegetal en un cazo y en una sartén, tuesta la harina con el aceite. Cuando la harina adquiera un color tostado, añade la leche de vegetal caliente. Remueve constantemente con unas varillas hasta que la bechamel espese ligeramente. añade al final una pizca de sal y de nuez moscada.<br />\r\nCalienta el horno a 220º.<br />\r\nMonta la lasaña. Empieza colocando en la base un poco de bechamel, coloca una primera capa de pasta, berenjena y bechamel. Contínua con otra capa de pasta, calabacín y bechamel. Repite el proceso hasta terminar la verdura. Finalmente, cubre con el resto de bechamel.<br />\r\nHornea a 220º durante 10 minutos.<br />\r\nPara terminar, pica el ajo y el cebollino fresco y mezcla con 50 ml. de aceite.<br />\r\nSirve la lasaña caliente junto con el aceite de ajo y cebollino para acompañar.','Lasaña Vegetal.png',2,40,4,1,0,'Chefmi');
/*!40000 ALTER TABLE `platos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos`
--

DROP TABLE IF EXISTS `tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos` (
  `id_tipo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos`
--

LOCK TABLES `tipos` WRITE;
/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` VALUES (1,'Entrantes'),(2,'Basicos'),(3,'Postres'),(4,'Carnes'),(5,'Pescados'),(6,'Vegetarianos');
/*!40000 ALTER TABLE `tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `contrasenia` varchar(30) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `perdida` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Chefmi','miriam.martinba93@gmail.com','123456','admin',NULL),(2,'Lauramartinn01','laura_mb_01@hotmail.com','skrillex1','cocinero',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votos`
--

DROP TABLE IF EXISTS `votos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votos` (
  `id_voto` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `voto` int NOT NULL,
  PRIMARY KEY (`id_voto`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votos`
--

LOCK TABLES `votos` WRITE;
/*!40000 ALTER TABLE `votos` DISABLE KEYS */;
INSERT INTO `votos` VALUES (1,2,4);
/*!40000 ALTER TABLE `votos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votos_platos`
--

DROP TABLE IF EXISTS `votos_platos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votos_platos` (
  `id_voto` int NOT NULL,
  `id_plato` int NOT NULL,
  PRIMARY KEY (`id_voto`,`id_plato`),
  KEY `id_plato` (`id_plato`),
  CONSTRAINT `votos_platos_ibfk_1` FOREIGN KEY (`id_voto`) REFERENCES `votos` (`id_voto`),
  CONSTRAINT `votos_platos_ibfk_2` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votos_platos`
--

LOCK TABLES `votos_platos` WRITE;
/*!40000 ALTER TABLE `votos_platos` DISABLE KEYS */;
INSERT INTO `votos_platos` VALUES (1,1);
/*!40000 ALTER TABLE `votos_platos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-17 13:42:42
