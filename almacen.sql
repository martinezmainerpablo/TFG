CREATE DATABASE  IF NOT EXISTS `almacen` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `almacen`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: almacen
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `almacenaje`
--

DROP TABLE IF EXISTS `almacenaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `almacenaje` (
  `idalmacenaje` int NOT NULL AUTO_INCREMENT,
  `referenciaFabricante` varchar(30) NOT NULL,
  `stock` int DEFAULT '0',
  `ubicacion` varchar(20) NOT NULL,
  `idinventario` int DEFAULT NULL,
  PRIMARY KEY (`idalmacenaje`),
  KEY `idinventario` (`idinventario`),
  KEY `referenciaFabricante` (`referenciaFabricante`),
  CONSTRAINT `almacenaje_ibfk_1` FOREIGN KEY (`idinventario`) REFERENCES `inventario` (`idinventario`),
  CONSTRAINT `almacenaje_ibfk_2` FOREIGN KEY (`referenciaFabricante`) REFERENCES `componente` (`referenciaFabricante`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `almacenaje`
--

LOCK TABLES `almacenaje` WRITE;
/*!40000 ALTER TABLE `almacenaje` DISABLE KEYS */;
INSERT INTO `almacenaje` VALUES (1,'146-8293',60,'fila1',1),(2,'UPW2V221MRD',75,'fila2',1);
/*!40000 ALTER TABLE `almacenaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idcategoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Sin silicio'),(2,'Con silicio');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componente`
--

DROP TABLE IF EXISTS `componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `componente` (
  `referenciaFabricante` varchar(30) NOT NULL,
  `idtipocomponente` int NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `caracteristicas` text NOT NULL,
  `dimensiones` varchar(60) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `idproveedor` int NOT NULL,
  PRIMARY KEY (`referenciaFabricante`),
  UNIQUE KEY `referenciaFabricante` (`referenciaFabricante`),
  KEY `idproveedor` (`idproveedor`),
  KEY `idtipocomponente` (`idtipocomponente`),
  CONSTRAINT `componente_ibfk_1` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`),
  CONSTRAINT `componente_ibfk_2` FOREIGN KEY (`idtipocomponente`) REFERENCES `tipocomponente` (`idtipocomponente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componente`
--

LOCK TABLES `componente` WRITE;
/*!40000 ALTER TABLE `componente` DISABLE KEYS */;
INSERT INTO `componente` VALUES ('146-8293',1,'Resistencia Axial RS PRO','Potencia Nominal	5W\r\nTolerancia	±5%\r\nAxial/Radial	Axial','15kΩ','resistenciaAxial.png',1),('1N4003',6,'Diodo, 1N4003-E3/54, 1A','Tipo de Montaje	Montaje en orificio pasante\r\nTipo de Encapsulado	DO-204AL\r\nCorriente Continua Máxima Directa	1A\r\nTensión Repetitiva Inversa de Pico	200V\r\nSerie	1N4003\r\nConfiguración de diodo	Simple\r\nTipo de Rectificador	Uso General\r\nTipo de Diodo	Rectificador\r\nCaída de tensión directa máxima	1.1V\r\nNúmero de Elementos por Chip	1\r\nTecnología de diodo	Conexión de silicio\r\nDiámetro	2.7mm\r\nTransitorios de corriente directa no repetitiva de pico	45A','2 pines','F6288997-01.png',4),('74HC574D',8,'Circuito integrado biestable, 74HC574D','Familia Lógica	74HC\r\nFunción Lógica	Tipo D\r\nTipo de Señal de Salida	Terminación Única\r\nTipo de Disparo	Borde positivo\r\nPolaridad	No Inversión\r\nTipo de Montaje	Montaje superficial\r\nTipo de Encapsulado	SOIC\r\nConteo de Pines	20\r\nNúmero de Elementos por Chip	8','13.1 x 7.5 x 2.25mm','R1713116-01.jpg',14),('ATSAMA5D27-WLSOM1',9,'Microprocesador ATSAMA5D27-WLSOM1','Ancho del Bus de Datos	32bit\r\nArquitectura del Conjunto de Instrucciones	ARM\r\nFrecuencia Máxima	500MHZ\r\nTipo de Encapsulado	SIP\r\nConteo de Pines	188','32 bit','R2009796-01.png',2),('B43455A0478M000',2,'Condensador electrolítico EPCOS serie B43455','Capacitancia	4700µF\r\nTensión	400V dc\r\nTipo de Montaje	Terminal Roscado\r\nTecnología	Aluminio electrolítico\r\nAltura	143.2mm\r\nMínima Temperatura de Funcionamiento	-25°C\r\nDiámetro	76.9mm\r\nMáxima Temperatura de Funcionamiento	+85°C\r\nVida Útil	10000h\r\nCorriente de Rizado	11A\r\nResistencia de Serie Equivalente	41mΩ\r\nSerie	B43455\r\nTolerancia	±20%','76.9 (Dia.) x 143.2mm','R2550096-01.png',9),('B43630A9128M060',2,'Condensador electrolítico, 1200μF','Capacitancia	1200µF\r\nTensión	400V dc\r\nTipo de Montaje	Encaje a presión\r\nTecnología	Aluminio electrolítico\r\nLongitud	55mm\r\nDiámetro	35mm\r\nMáxima Temperatura de Funcionamiento	+85°C\r\nPaso del Pin	10mm','35 x 55mm','Y2098690-01.png',9),('B82726S2203A020',3,'Bobina de arresto 1,6 mH, Ferrita','Inductancia	1,6 mH\r\nMáxima Corriente DC	20A\r\nTipo de Montaje	Radial\r\nMáxima Resistencia DC	4.5mΩ\r\nTolerancia	-30 → +50%\r\nMaterial del Núcleo	Ferrita\r\nMáxima Frecuencia Auto-resonante	10kHz\r\nPaso del Pin	10mm\r\nSerie	B82726S\r\nDiámetro del Pin	2mm\r\nTipo terminal	Contacto para PC\r\nMáxima Temperatura de Funcionamiento	+125°C\r\nMínima Temperatura de Funcionamiento	-40°C','45 x 25 x 41mm','F8711376-01.png',9),('B82726S3543N040',3,'Bobina de arresto EPCOS, 190 μH -30','Inductancia	190 μH\r\nMáxima Corriente DC	54A\r\nTipo de Montaje	Radial\r\nMáxima Resistencia DC	1.1mΩ\r\nTolerancia	-30 → +50%\r\nMaterial del Núcleo	Ferrita\r\nMáxima Frecuencia Auto-resonante	100kHz\r\nPaso del Pin	30mm\r\nSerie	B82726S\r\nMínima Temperatura de Funcionamiento	-40°C\r\nMáxima Temperatura de Funcionamiento	+125°C\r\nDiámetro del Pin	2.5mm','55 x 34 x 50mm','R8711382-01.png',9),('B82726S6123N020',3,'Bobina de arresto EPCOS','Máxima Resistencia DC	8.4mΩ\r\nTolerancia	±30%\r\nLongitud	52mm\r\nProfundidad	28mm\r\nAltura	55mm\r\nInductancia	3,3 mH	','52 x 28 x 55mm','BobinaEPCOS.png',9),('BC63916-D74Z',7,'Transistor digital, BC63916-D74Z','Tipo de Transistor	NPN\r\nTensión Máxima Colector-Emisor	100 V\r\nTipo de Encapsulado	TO-92\r\nTipo de Montaje	Montaje en orificio pasante\r\nDisipación de Potencia Máxima	830 mW\r\nConfiguración de transistor	Simple\r\nTensión Máxima Emisor-Base	5 V\r\nConteo de Pines	3','5.2 x 4.19 x 5.33mm','P1868788-01.png',12),('DSPIC33CH128MP505-I',9,'Microprocesador DSPIC33CH128MP505-I/PT','Nombre de la Familia	dsPIC33CH\r\nAncho del Bus de Datos	16bit\r\nArquitectura del Conjunto de Instrucciones	DSP, MCU\r\nFrecuencia Máxima	180 MHz, 200 MHz\r\nTecnología de Fabricación	CMOS\r\nTipo de Montaje	Montaje superficial\r\nTipo de Encapsulado	TQFP\r\nConteo de Pines	48\r\nTensión de Alimentación de Funcionamiento Típica	3 → 3,6 V\r\nTemperatura de Funcionamiento Mínima	-40 °C\r\nTemperatura Máxima de Funcionamiento	+85 °C','7 x 7 x 1.05mm','R1757191-01.png',2),('DSPIC33CK256MP502',9,'AEC-Q100 Microprocesador DSPIC33CK256MP502-I/SS','Nombre de la Familia	dsPIC\r\nAncho del Bus de Datos	16bit\r\nFrecuencia Máxima	100MHZ\r\nTensión E/S	3 → 3.6V\r\nTecnología de Fabricación	CMOS\r\nTipo de Montaje	Montaje superficial\r\nTipo de Encapsulado	SSOP\r\nConteo de Pines	28\r\nTensión de Alimentación de Funcionamiento Típica	3,6 V (máximo)\r\nEstándar de automoción	AEC-Q100\r\nTemperatura Máxima de Funcionamiento	+85 °C\r\nTemperatura de Funcionamiento Mínima	-40 °C','10.5 x 5.6 x 1.85mm','R1793960-01.png',2),('ECA1JHG470',2,'Condensador electrolítico serie NHG, 47μF','Capacitancia	47µF\r\nTensión	63V dc\r\nTipo de Montaje	Radial, Orificio pasante\r\nTecnología	Aluminio electrolítico\r\nAltura	11.2mm\r\nMínima Temperatura de Funcionamiento	-55°C\r\nDiámetro	6.3mm\r\nMáxima Temperatura de Funcionamiento	+105°C\r\nPaso del Pin	2.5mm\r\nVida Útil	1000h\r\nSerie	NHG\r\nCorriente de Pérdida	3 μA\r\nPolarizado	Polar\r\nTolerancia	±20%\r\nCorriente de Rizado	120mA','6.3 (Dia.) x 11.2mm','F3654357-01.jpg',16),('G2RV-ST700',4,'Relé electromecánico Omron G2RV-ST','Tipo de Montaje	Carril DIN\r\nNúmero de polos	1\r\nCorriente de Carga	6A\r\nRango de Tensión de Carga	250V ac\r\nTensión de Entrada Mínimo	38.4V\r\nTensión de Entrada Máxima	52.8V\r\nTensión de Conmutación	400V ac\r\nTipo de Terminal	Roscado\r\nProfundidad	6.2mm\r\nAltura	90mm\r\nLongitud	88mm\r\nSerie	G2RV-ST\r\nMaterial de los Contactos	Aleación de plata','88 x 90 x 6.2mm','F2711855-01.jpg',11),('NVHL160N120SC1',7,'Transistor MOSFET onsemi NVHL160N120SC1','Tipo de Canal	N\r\nCorriente Máxima Continua de Drenaje	17 A\r\nTensión Máxima Drenador-Fuente	1.200 V\r\nTipo de Encapsulado	TO-247-4\r\nSerie	NVH\r\nTipo de Montaje	Montaje en orificio pasante\r\nConteo de Pines	4\r\nResistencia Máxima Drenador-Fuente	0,16 Ω\r\nModo de Canal	Mejora\r\nTensión de umbral de puerta máxima	4.3V\r\nMaterial del transistor	SiC\r\nNúmero de Elementos por Chip	1','4 pines','R2025747-01.png',12),('S8KC-13',6,'Diodo, S8KC-13','Tipo de Encapsulado	DO-214AB (SMC)\r\nCorriente Continua Máxima Directa	8A\r\nTensión Repetitiva Inversa de Pico	800V\r\nConfiguración de diodo	Simple\r\nTipo de Rectificador	Uso General\r\nTipo de Diodo	Rectificador\r\n','2 pines','F7514830-01.jpg',10),('SB5100-T',6,'Diodo, SB5100-T, Rectificador Schottky','Tipo de Montaje	Montaje en orificio pasante\r\nTipo de Encapsulado	DO-201AD\r\nCorriente Continua Máxima Directa	5A\r\nTensión Repetitiva Inversa de Pico	100V\r\nConfiguración de diodo	Simple\r\nTipo de Rectificador	Rectificador Schottky\r\nTipo de Diodo	Schottky\r\nCaída de tensión directa máxima	800mV\r\nNúmero de Elementos por Chip	1\r\nTecnología de diodo	Schottky\r\nDiámetro	5.3mm\r\nTransitorios de corriente directa no repetitiva de pico	150A','2 pines','F7514843-01.png',4),('SN74HC273PW',8,'Circuito integrado biestable, SN74HC273PW','Familia Lógica	HC\r\nFunción Lógica	Tipo D\r\nTipo de Entrada	Terminación Única\r\nTipo de Señal de Salida	Terminación Única\r\nTipo de Disparo	Borde positivo\r\nPolaridad	No Inversión\r\nTipo de Montaje	Montaje superficial\r\nTipo de Encapsulado	TSSOP\r\nConteo de Pines	20\r\n','6.5 x 4.4 x 1.15mm','R6632066-01.png',13),('SN74HC74N',8,'Circuito integrado biestable, SN74HC74N','Familia Lógica	HC\r\nFunción Lógica	Tipo D\r\nTipo de Entrada	Terminación Única\r\nTipo de Señal de Salida	Diferencial\r\nTipo de Disparo	Borde positivo\r\nPolaridad	Inversión\r\nTipo de Montaje	Montaje en orificio pasante\r\nTipo de Encapsulado	PDIP\r\nConteo de Pines	14','19.3 x 6.35 x 4.57mm','F0442987-01.png',13),('SN74LVC2G74DCUR',8,'Circuito integrado biestable, SN74LVC2G74DCUR','Familia Lógica	74LVC\r\nFunción Lógica	Tipo D\r\nTipo de Entrada	CMOS\r\nTipo de Salida	Diferencial\r\nTipo de Señal de Salida	Diferencial\r\nTipo de Encapsulado	VSSOP\r\nConteo de Pines	8','8 pines','F8122561-01.png',13),('UPW2V221MRD',2,'Condensador electrolítico Nichicon serie PW, 220μF','Capacitancia	220µF\r\nTensión	350V dc\r\nTecnología	Aluminio electrolítico\r\nDimensiones	25 (Dia.) x 50mm\r\nAltura	50mm\r\nMínima Temperatura de Funcionamiento	-40°C\r\nDiámetro	25mm\r\nMáxima Temperatura de Funcionamiento	+105°C','25 (Dia.) x 50mm','F7153237-01.png',8),('UVY1C222MPD',2,'Condensador electrolítico Nichicon serie VY, 2200μF','Capacitancia	2200µF\r\nTensión	16V dc\r\nTipo de Montaje	Radial, Orificio pasante\r\nTecnología	Aluminio electrolítico\r\nAltura	20mm\r\nMínima Temperatura de Funcionamiento	-55°C\r\nDiámetro	10mm\r\nMáxima Temperatura de Funcionamiento	+105°C','10 (Dia.) x 20mm','F7395260-01.png',8),('UVY1E103MHD',2,'Condensador electrolítico Nichicon serie VY, 10000μF','Capacitancia	10000µF\r\nTensión	25V dc\r\nTipo de Montaje	Radial, Orificio pasante\r\nTecnología	Aluminio electrolítico\r\nDimensiones	18 (Dia.) x 40mm\r\nAltura	40mm\r\nMínima Temperatura de Funcionamiento	-55°C\r\nDiámetro	18mm\r\nMáxima Temperatura de Funcionamiento	+105°C','18 (Dia.) x 40mm','F7395295-01.png',8),('WR222230-26M8-G',3,'Bobina de carga inalámbrica TDK','Inductancia	27 μH\r\nFunción	Receptor\r\nMáxima Resistencia DC	1.1Ω\r\nSerie	WR\r\nMaterial del Núcleo	Núcleo de ferrita\r\nMáxima Temperatura de Funcionamiento	+70°C\r\nMínima Temperatura de Funcionamiento	-30°C\r\nTipo de Montaje	Montaje en orificio pasante\r\nDiámetro	22mm\r\nAltura 0.87mm','22 (Dia.) x 0.87mm','Y1858385-01.png',15),('ZTX857STZ',7,'Transistor, ZTX857STZ','Tipo de Transistor	NPN\r\nCorriente DC Máxima del Colector	3 A\r\nTensión Máxima Colector-Emisor	300 V\r\nTipo de Encapsulado	TO-92\r\nTipo de Montaje	Montaje en orificio pasante\r\nDisipación de Potencia Máxima	1,2 W\r\nGanancia Mínima de Corriente DC	100\r\nConfiguración de transistor	Simple','4.77 x 2.41 x 4.01mm','R8855671-01.png',10);
/*!40000 ALTER TABLE `componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `composicion`
--

DROP TABLE IF EXISTS `composicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `composicion` (
  `idcomposicion` int NOT NULL AUTO_INCREMENT,
  `idreferenciapcb` int NOT NULL,
  `referenciaFabricante` varchar(30) DEFAULT NULL,
  `posicion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idcomposicion`),
  KEY `idreferenciapcb` (`idreferenciapcb`),
  KEY `referenciaFabricante` (`referenciaFabricante`),
  CONSTRAINT `composicion_ibfk_1` FOREIGN KEY (`idreferenciapcb`) REFERENCES `referenciapcb` (`idreferenciapcb`),
  CONSTRAINT `composicion_ibfk_2` FOREIGN KEY (`referenciaFabricante`) REFERENCES `componente` (`referenciaFabricante`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `composicion`
--

LOCK TABLES `composicion` WRITE;
/*!40000 ALTER TABLE `composicion` DISABLE KEYS */;
INSERT INTO `composicion` VALUES (1,4,'146-8293','c1'),(2,4,'146-8293','c3'),(3,4,'SN74HC273PW','c19'),(4,4,'B82726S6123N020','d19'),(5,4,'DSPIC33CH128MP505-I','F9');
/*!40000 ALTER TABLE `composicion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventario` (
  `idinventario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `idusuario` int DEFAULT NULL,
  PRIMARY KEY (`idinventario`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (1,'inventario1','951',2),(3,'inv2','789',4);
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `idproveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(150) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idproveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'RS-PRO','951753348','rspro@example.com','calle madrid 45','rs.png'),(2,'Microchip Technology Inc.','654789222','microchip@example.com','calle teruel 2','microchip.png'),(3,'TE Connectivity','365478921','TEConnectivity@example.com','calle sal 25','connectivity.png'),(4,'Vishay Intertechnology','456987123','vishay@example.com','calle costa 26','Vishay.png'),(5,'Nexperia','197538426','nexperia@example.com','calle marcelino 33','Nexperia.png'),(8,'Nichicon','987456258','nichico@example.com','calle diaz 25','Nichicon.jpg'),(9,'EPCOS','369874512','epcos@example.com','calle perez 25','M1202-01.jpg'),(10,'DiodesZetex','842675913','diodeszetex@example.com','calle madrid 9','M2480-01.jpg'),(11,' Omron','698745321','omron@example.com','calle salamanca 2','M0157-01.jpg'),(12,'Onsemi','486215973','onsemi@example.com','calle figura 6','M4039-01.jpg'),(13,' Texas Instruments','789654123','texas@example.com','calle teruel 9','M3485-01.jpg'),(14,'Toshiba','584236914','toshiba@example.com','calle ruta 6','M3940-01.jpg'),(15,'TDK','963248211','tdk@example.com','calle luna 9','M2030-01.jpg'),(16,'Panasonic','875426351','panasonic@example.com','calle teruel 60','M4089-01.jpg');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referenciapcb`
--

DROP TABLE IF EXISTS `referenciapcb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referenciapcb` (
  `idreferenciapcb` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `idusuario` int DEFAULT NULL,
  PRIMARY KEY (`idreferenciapcb`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `referenciapcb_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referenciapcb`
--

LOCK TABLES `referenciapcb` WRITE;
/*!40000 ALTER TABLE `referenciapcb` DISABLE KEYS */;
INSERT INTO `referenciapcb` VALUES (2,'PCB002',1),(3,'PCB001',2),(4,'PCB003',2);
/*!40000 ALTER TABLE `referenciapcb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sugerencia`
--

DROP TABLE IF EXISTS `sugerencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sugerencia` (
  `idsugerencia` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text,
  `estado` varchar(3) DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  PRIMARY KEY (`idsugerencia`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `sugerencia_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sugerencia`
--

LOCK TABLES `sugerencia` WRITE;
/*!40000 ALTER TABLE `sugerencia` DISABLE KEYS */;
INSERT INTO `sugerencia` VALUES (1,'añadir componente res25','Potencia Nominal	5W\r\nTolerancia	±5%\r\nAxial/Radial	Axial','A',2),(2,'Añadir Proveedor','Nombre: exp\r\ncorreo: exp@example.com\r\nTelefono: 546782139\r\nDireccion: calle la palma 5','P',2),(3,'Borrar componente','borrar el componente con ref 74HC574D','R',2),(4,'Borrar proveedor','borrar al proveedor Toshiba porque no vamos a trabajar mas con el.','P',2);
/*!40000 ALTER TABLE `sugerencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocomponente`
--

DROP TABLE IF EXISTS `tipocomponente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipocomponente` (
  `idtipocomponente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `idcategoria` int NOT NULL,
  PRIMARY KEY (`idtipocomponente`),
  KEY `idcategoria` (`idcategoria`),
  CONSTRAINT `tipocomponente_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocomponente`
--

LOCK TABLES `tipocomponente` WRITE;
/*!40000 ALTER TABLE `tipocomponente` DISABLE KEYS */;
INSERT INTO `tipocomponente` VALUES (1,'Resistencias',1),(2,'Condensadores',1),(3,'Bobinas',1),(4,'Electromecanicos',1),(5,'Otros',1),(6,'Diodos',2),(7,'Transistores',2),(8,'Circuitos integrados',2),(9,'Microprocesadores',2),(10,'Sensores',2),(11,'Otros',2);
/*!40000 ALTER TABLE `tipocomponente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `login` varchar(150) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `admin` bit(1) DEFAULT b'0',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Administrador','admin@example.com','$2y$10$7IlU4yEeKkEPD82Ih7NFCeTWTwGQQi8FZNP9TUo7K6c35Rf.1w1fW',_binary ''),(2,'Audiobus','audiobus@example.com','$2y$10$GjjrKXKwvQjprToE0ktZJ.6ec.6ZSMxR4VkmDrM7zqU5.QY1Gls4.',_binary '\0'),(4,'inv2','inv2@example.com','$2y$10$cdmjgNU72UJCKOFV8G7CP.avbazMJaIkGYBFszQV3RLQrQV60/S1O',_binary '\0');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-28  8:59:38
