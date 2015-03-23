-- MySQL dump 10.13  Distrib 5.6.16, for Win32 (x86)
--
-- Host: localhost    Database: pizarra
-- ------------------------------------------------------
-- Server version	5.6.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clases`
--

DROP TABLE IF EXISTS `clases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_dominio` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clases`
--

LOCK TABLES `clases` WRITE;
/*!40000 ALTER TABLE `clases` DISABLE KEYS */;
INSERT INTO `clases` VALUES (1,'Señales',1,'2014-12-07 12:09:02','0000-00-00 00:00:00'),(2,'Primeros Auxilios',1,'2014-12-07 12:09:02','0000-00-00 00:00:00'),(3,'Semáforos',1,'2014-12-07 12:09:02','0000-00-00 00:00:00'),(4,'Condensadores',2,'2014-12-07 12:09:02','0000-00-00 00:00:00'),(5,'Diodos',2,'2014-12-08 07:10:42','2014-12-08 07:10:42'),(6,'Corriente Alterna',2,'2014-12-08 07:11:31','2014-12-08 07:11:31'),(7,'Tejidos',3,'2014-12-08 07:13:21','2014-12-08 07:13:21'),(9,'Fibras',3,'2014-12-08 07:15:20','2014-12-08 07:15:20');
/*!40000 ALTER TABLE `clases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clasexalumno`
--

DROP TABLE IF EXISTS `clasexalumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clasexalumno` (
  `idClase` bigint(20) unsigned NOT NULL,
  `idAlumno` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`idClase`,`idAlumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clasexalumno`
--

LOCK TABLES `clasexalumno` WRITE;
/*!40000 ALTER TABLE `clasexalumno` DISABLE KEYS */;
INSERT INTO `clasexalumno` VALUES (1,1),(1,3);
/*!40000 ALTER TABLE `clasexalumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dominiopivot`
--

DROP TABLE IF EXISTS `dominiopivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dominiopivot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_dominio` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dominiopivot`
--

LOCK TABLES `dominiopivot` WRITE;
/*!40000 ALTER TABLE `dominiopivot` DISABLE KEYS */;
INSERT INTO `dominiopivot` VALUES (24,2,8,'2015-03-12 13:27:45','0000-00-00 00:00:00'),(25,2,10,'2015-03-12 13:27:45','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `dominiopivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dominios`
--

DROP TABLE IF EXISTS `dominios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dominios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dominios`
--

LOCK TABLES `dominios` WRITE;
/*!40000 ALTER TABLE `dominios` DISABLE KEYS */;
INSERT INTO `dominios` VALUES (1,'Seguridad Vial','2014-12-07 11:42:51','0000-00-00 00:00:00'),(2,'Electrónica','2014-12-07 11:42:51','0000-00-00 00:00:00'),(3,'Anatomía','2014-12-07 11:42:51','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `dominios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elementos`
--

DROP TABLE IF EXISTS `elementos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elementos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `clase_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `fullname` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elementos`
--

LOCK TABLES `elementos` WRITE;
/*!40000 ALTER TABLE `elementos` DISABLE KEYS */;
INSERT INTO `elementos` VALUES (1,'fondo1',2,10,'fondo1.jpg','2015-03-02 06:54:33','2015-03-02 06:54:33');
/*!40000 ALTER TABLE `elementos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escenarios`
--

DROP TABLE IF EXISTS `escenarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escenarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `clase_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `Nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `tipo` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escenarios`
--

LOCK TABLES `escenarios` WRITE;
/*!40000 ALTER TABLE `escenarios` DISABLE KEYS */;
INSERT INTO `escenarios` VALUES (1,2,10,'fondo1','fondo1.jpg',0,'','2015-03-18 15:20:37','2015-03-18 15:20:37');
/*!40000 ALTER TABLE `escenarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escenarioximagen`
--

DROP TABLE IF EXISTS `escenarioximagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escenarioximagen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Escenario` bigint(20) NOT NULL,
  `Id_imagen` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escenarioximagen`
--

LOCK TABLES `escenarioximagen` WRITE;
/*!40000 ALTER TABLE `escenarioximagen` DISABLE KEYS */;
INSERT INTO `escenarioximagen` VALUES (2,1,2),(3,1,3),(5,1,4),(6,1,5),(7,1,6),(8,1,5),(9,1,7),(10,1,7),(11,1,7),(12,1,7),(13,1,7),(14,1,7),(16,1,9),(17,1,8),(18,1,10),(19,1,11),(20,1,12),(21,1,23),(23,1,35),(25,2,1),(26,2,2),(27,2,3),(28,2,4),(29,2,26),(30,2,23),(31,2,24),(32,3,27),(33,3,23),(34,3,1),(36,2,9),(37,1,35),(38,3,23),(39,3,1),(40,3,27),(42,1,29),(43,1,29);
/*!40000 ALTER TABLE `escenarioximagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_dominio` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materiales`
--

DROP TABLE IF EXISTS `materiales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materiales` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` char(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `documento` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `desde` datetime NOT NULL,
  `hasta` datetime NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL,
  `time` char(9) COLLATE utf8_spanish_ci NOT NULL DEFAULT '00:00',
  `testype` int(10) unsigned NOT NULL,
  `examen` tinyint(1) unsigned NOT NULL,
  `id_dominio` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materiales`
--

LOCK TABLES `materiales` WRITE;
/*!40000 ALTER TABLE `materiales` DISABLE KEYS */;
INSERT INTO `materiales` VALUES (8,'Mirame el titulito','Como chorrea, como chorrea la superwoper cuando la aprietaaaas...','','2015-02-20 00:00:00','2015-02-23 23:59:59',1,'00:00',0,0,1,'2015-03-01 19:58:17','2015-02-20 15:31:16'),(12,'eklfjaojdf','fasghyjdasddf','/Documentos/fondo1.jpg','2015-03-08 00:00:00','2015-03-10 23:59:57',0,'00:00',0,0,2,'2015-03-17 21:34:28','2015-03-17 17:33:52');
/*!40000 ALTER TABLE `materiales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materialespivot`
--

DROP TABLE IF EXISTS `materialespivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materialespivot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `id_material` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materialespivot`
--

LOCK TABLES `materialespivot` WRITE;
/*!40000 ALTER TABLE `materialespivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `materialespivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pregunta` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `respuestas` tinyint(2) unsigned NOT NULL,
  `id_test` int(11) unsigned NOT NULL,
  `valor` float unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuestas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `respuesta` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_test` int(11) unsigned NOT NULL,
  `id_pregunta` int(11) unsigned NOT NULL,
  `correcta` tinyint(1) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuestas`
--

LOCK TABLES `respuestas` WRITE;
/*!40000 ALTER TABLE `respuestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temarios`
--

DROP TABLE IF EXISTS `temarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temarios` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDominio` bigint(20) NOT NULL,
  `nombre` char(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temarios`
--

LOCK TABLES `temarios` WRITE;
/*!40000 ALTER TABLE `temarios` DISABLE KEYS */;
INSERT INTO `temarios` VALUES (1,1,'Señales de tráfico'),(2,1,'Vehículos'),(3,2,'Resistencias'),(4,2,'Condensandores'),(5,3,'Órganos'),(6,3,'Huesos'),(7,1,'Obligación'),(8,1,'PRUEBA2'),(9,1,'prueba'),(10,1,'otra mas'),(11,1,'a ver esta'),(12,1,'familia nueva'),(13,1,'familia nueva');
/*!40000 ALTER TABLE `temarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testcategories`
--

DROP TABLE IF EXISTS `testcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testcategories` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `penaliza` tinyint(1) unsigned NOT NULL,
  `monorespuesta` tinyint(1) unsigned NOT NULL,
  `multirespuesta` tinyint(1) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testcategories`
--

LOCK TABLES `testcategories` WRITE;
/*!40000 ALTER TABLE `testcategories` DISABLE KEYS */;
INSERT INTO `testcategories` VALUES (1,'Test sin penalizar',0,1,0,'2015-02-23 12:54:08'),(2,'Test penalizando',1,1,0,'2015-02-23 12:54:08'),(3,'Test sin penalizar',0,0,1,'2015-02-23 12:54:08');
/*!40000 ALTER TABLE `testcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` char(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_clase` int(11) unsigned NOT NULL,
  `id_category` tinyint(1) unsigned NOT NULL,
  `id_dominio` int(11) unsigned NOT NULL,
  `preguntas` tinyint(2) unsigned NOT NULL,
  `respuestas` tinyint(3) unsigned NOT NULL,
  `puntuacion` tinyint(3) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `undoimages`
--

DROP TABLE IF EXISTS `undoimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `undoimages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dir` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `undoimages`
--

LOCK TABLES `undoimages` WRITE;
/*!40000 ALTER TABLE `undoimages` DISABLE KEYS */;
/*!40000 ALTER TABLE `undoimages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `password` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `roles` enum('admin','alumno') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'alumno',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `firstname` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `phone` char(9) COLLATE utf8_unicode_ci NOT NULL DEFAULT '""',
  `remember_token` char(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nif` char(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `adress` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `locality` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `province` char(120) COLLATE utf8_unicode_ci NOT NULL,
  `cp` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `borndate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `obs` char(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7,'Royer','papa@gmail.com',1,'$2y$10$gzggzE5bwK7CnQPC3ScJ5u6PWHxgpLvFj.RoL9JK.zmGslo1BB6qK','0000-00-00 00:00:00','alumno','2015-03-02 16:38:12','2015-01-15 17:19:03','Juan Carlos','Jenaro','673215987','cWO1xRnnHUEfbfYneocEXkPfLmsXgvAty3VWfZynoUlCu0Mxt6ZULojToxlj','','','','','','0000-00-00 00:00:00',''),(8,'Andres','andresito@gmail.com',1,'$2y$10$GkIFu39D5iziY5/72kW/KuLBEpzj4cm.KVziX9K7M5BX3w8Njjnz.','0000-00-00 00:00:00','alumno','2015-03-02 16:38:15','2014-12-16 20:08:07','Andrés','Jenaro','',NULL,'','','','','','0000-00-00 00:00:00',''),(10,'Prado','mdpcamacho@gmail.com',1,'$2y$10$ogeyrkg6JeVceIapmu9sw.61nt.vAhqFI6LtBxfyKCfdOjX7lcZHC','0000-00-00 00:00:00','alumno','2015-03-02 16:38:18','2015-02-06 10:03:53','María del Prado','Camacho Rojas','','Zl2CIophbZm69fqKn8iVx0SrJ6gEWkbz5wl1nJfJttjSlyH4MnqM0cmnQpYy','','','','','','0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-23 12:46:09
