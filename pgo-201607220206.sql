-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: pgo
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

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
-- Table structure for table `api_key`
--

DROP TABLE IF EXISTS `api_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_key` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `api_key_user_id_foreign` (`user_id`),
  KEY `api_key_key_index` (`key`),
  CONSTRAINT `api_key_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_key`
--

LOCK TABLES `api_key` WRITE;
/*!40000 ALTER TABLE `api_key` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_log`
--

DROP TABLE IF EXISTS `api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `api_key_id` int(10) unsigned NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `request` text COLLATE utf8_unicode_ci NOT NULL,
  `response` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `api_log_api_key_id_foreign` (`api_key_id`),
  CONSTRAINT `api_log_api_key_id_foreign` FOREIGN KEY (`api_key_id`) REFERENCES `api_key` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_log`
--

LOCK TABLES `api_log` WRITE;
/*!40000 ALTER TABLE `api_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` double(8,2) NOT NULL,
  `lng` double(8,2) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  KEY `countries_country_code_index` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES ('AD',42.55,1.60,'Andorra'),('AE',23.42,53.85,'United Arab Emirates'),('AF',33.94,67.71,'Afghanistan'),('AG',17.06,-61.80,'Antigua and Barbuda'),('AI',18.22,-63.07,'Anguilla'),('AL',41.15,20.17,'Albania'),('AM',40.07,45.04,'Armenia'),('AN',12.23,-69.06,'Netherlands Antilles'),('AO',-11.20,17.87,'Angola'),('AQ',-75.25,-0.07,'Antarctica'),('AR',-38.42,-63.62,'Argentina'),('AS',-14.27,-170.13,'American Samoa'),('AT',47.52,14.55,'Austria'),('AU',-25.27,133.78,'Australia'),('AW',12.52,-69.97,'Aruba'),('AZ',40.14,47.58,'Azerbaijan'),('BA',43.92,17.68,'Bosnia and Herzegovina'),('BB',13.19,-59.54,'Barbados'),('BD',23.68,90.36,'Bangladesh'),('BE',50.50,4.47,'Belgium'),('BF',12.24,-1.56,'Burkina Faso'),('BG',42.73,25.49,'Bulgaria'),('BH',25.93,50.64,'Bahrain'),('BI',-3.37,29.92,'Burundi'),('BJ',9.31,2.32,'Benin'),('BM',32.32,-64.76,'Bermuda'),('BN',4.54,114.73,'Brunei'),('BO',-16.29,-63.59,'Bolivia'),('BR',-14.24,-51.93,'Brazil'),('BS',25.03,-77.40,'Bahamas'),('BT',27.51,90.43,'Bhutan'),('BV',-54.42,3.41,'Bouvet Island'),('BW',-22.33,24.68,'Botswana'),('BY',53.71,27.95,'Belarus'),('BZ',17.19,-88.50,'Belize'),('CA',56.13,-106.35,'Canada'),('CC',-12.16,96.87,'Cocos [Keeling] Islands'),('CD',-4.04,21.76,'Congo [DRC]'),('CF',6.61,20.94,'Central African Republic'),('CG',-0.23,15.83,'Congo [Republic]'),('CH',46.82,8.23,'Switzerland'),('CI',7.54,-5.55,'Côte d\'Ivoire'),('CK',-21.24,-159.78,'Cook Islands'),('CL',-35.68,-71.54,'Chile'),('CM',7.37,12.35,'Cameroon'),('CN',35.86,104.20,'China'),('CO',4.57,-74.30,'Colombia'),('CR',9.75,-83.75,'Costa Rica'),('CU',21.52,-77.78,'Cuba'),('CV',16.00,-24.01,'Cape Verde'),('CX',-10.45,105.69,'Christmas Island'),('CY',35.13,33.43,'Cyprus'),('CZ',49.82,15.47,'Czech Republic'),('DE',51.17,10.45,'Germany'),('DJ',11.83,42.59,'Djibouti'),('DK',56.26,9.50,'Denmark'),('DM',15.41,-61.37,'Dominica'),('DO',18.74,-70.16,'Dominican Republic'),('DZ',28.03,1.66,'Algeria'),('EC',-1.83,-78.18,'Ecuador'),('EE',58.60,25.01,'Estonia'),('EG',26.82,30.80,'Egypt'),('EH',24.22,-12.89,'Western Sahara'),('ER',15.18,39.78,'Eritrea'),('ES',40.46,-3.75,'Spain'),('ET',9.14,40.49,'Ethiopia'),('FI',61.92,25.75,'Finland'),('FJ',-16.58,179.41,'Fiji'),('FK',-51.80,-59.52,'Falkland Islands [Islas Malvinas]'),('FM',7.43,150.55,'Micronesia'),('FO',61.89,-6.91,'Faroe Islands'),('FR',46.23,2.21,'France'),('GA',-0.80,11.61,'Gabon'),('GB',55.38,-3.44,'United Kingdom'),('GD',12.26,-61.60,'Grenada'),('GE',42.32,43.36,'Georgia'),('GF',3.93,-53.13,'French Guiana'),('GG',49.47,-2.59,'Guernsey'),('GH',7.95,-1.02,'Ghana'),('GI',36.14,-5.35,'Gibraltar'),('GL',71.71,-42.60,'Greenland'),('GM',13.44,-15.31,'Gambia'),('GN',9.95,-9.70,'Guinea'),('GP',17.00,-62.07,'Guadeloupe'),('GQ',1.65,10.27,'Equatorial Guinea'),('GR',39.07,21.82,'Greece'),('GS',-54.43,-36.59,'South Georgia and the South Sandwich Islands'),('GT',15.78,-90.23,'Guatemala'),('GU',13.44,144.79,'Guam'),('GW',11.80,-15.18,'Guinea-Bissau'),('GY',4.86,-58.93,'Guyana'),('GZ',31.35,34.31,'Gaza Strip'),('HK',22.40,114.11,'Hong Kong'),('HM',-53.08,73.50,'Heard Island and McDonald Islands'),('HN',15.20,-86.24,'Honduras'),('HR',45.10,15.20,'Croatia'),('HT',18.97,-72.29,'Haiti'),('HU',47.16,19.50,'Hungary'),('ID',-0.79,113.92,'Indonesia'),('IE',53.41,-8.24,'Ireland'),('IL',31.05,34.85,'Israel'),('IM',54.24,-4.55,'Isle of Man'),('IN',20.59,78.96,'India'),('IO',-6.34,71.88,'British Indian Ocean Territory'),('IQ',33.22,43.68,'Iraq'),('IR',32.43,53.69,'Iran'),('IS',64.96,-19.02,'Iceland'),('IT',41.87,12.57,'Italy'),('JE',49.21,-2.13,'Jersey'),('JM',18.11,-77.30,'Jamaica'),('JO',30.59,36.24,'Jordan'),('JP',36.20,138.25,'Japan'),('KE',-0.02,37.91,'Kenya'),('KG',41.20,74.77,'Kyrgyzstan'),('KH',12.57,104.99,'Cambodia'),('KI',-3.37,-168.73,'Kiribati'),('KM',-11.88,43.87,'Comoros'),('KN',17.36,-62.78,'Saint Kitts and Nevis'),('KP',40.34,127.51,'North Korea'),('KR',35.91,127.77,'South Korea'),('KW',29.31,47.48,'Kuwait'),('KY',19.51,-80.57,'Cayman Islands'),('KZ',48.02,66.92,'Kazakhstan'),('LA',19.86,102.50,'Laos'),('LB',33.85,35.86,'Lebanon'),('LC',13.91,-60.98,'Saint Lucia'),('LI',47.17,9.56,'Liechtenstein'),('LK',7.87,80.77,'Sri Lanka'),('LR',6.43,-9.43,'Liberia'),('LS',-29.61,28.23,'Lesotho'),('LT',55.17,23.88,'Lithuania'),('LU',49.82,6.13,'Luxembourg'),('LV',56.88,24.60,'Latvia'),('LY',26.34,17.23,'Libya'),('MA',31.79,-7.09,'Morocco'),('MC',43.75,7.41,'Monaco'),('MD',47.41,28.37,'Moldova'),('ME',42.71,19.37,'Montenegro'),('MG',-18.77,46.87,'Madagascar'),('MH',7.13,171.18,'Marshall Islands'),('MK',41.61,21.75,'Macedonia [FYROM]'),('ML',17.57,-4.00,'Mali'),('MM',21.91,95.96,'Myanmar [Burma]'),('MN',46.86,103.85,'Mongolia'),('MO',22.20,113.54,'Macau'),('MP',17.33,145.38,'Northern Mariana Islands'),('MQ',14.64,-61.02,'Martinique'),('MR',21.01,-10.94,'Mauritania'),('MS',16.74,-62.19,'Montserrat'),('MT',35.94,14.38,'Malta'),('MU',-20.35,57.55,'Mauritius'),('MV',3.20,73.22,'Maldives'),('MW',-13.25,34.30,'Malawi'),('MX',23.63,-102.55,'Mexico'),('MY',4.21,101.98,'Malaysia'),('MZ',-18.67,35.53,'Mozambique'),('NA',-22.96,18.49,'Namibia'),('NC',-20.90,165.62,'New Caledonia'),('NE',17.61,8.08,'Niger'),('NF',-29.04,167.95,'Norfolk Island'),('NG',9.08,8.68,'Nigeria'),('NI',12.87,-85.21,'Nicaragua'),('NL',52.13,5.29,'Netherlands'),('NO',60.47,8.47,'Norway'),('NP',28.39,84.12,'Nepal'),('NR',-0.52,166.93,'Nauru'),('NU',-19.05,-169.87,'Niue'),('NZ',-40.90,174.89,'New Zealand'),('OM',21.51,55.92,'Oman'),('PA',8.54,-80.78,'Panama'),('PE',-9.19,-75.02,'Peru'),('PF',-17.68,-149.41,'French Polynesia'),('PG',-6.31,143.96,'Papua New Guinea'),('PH',12.88,121.77,'Philippines'),('PK',30.38,69.35,'Pakistan'),('PL',51.92,19.15,'Poland'),('PM',46.94,-56.27,'Saint Pierre and Miquelon'),('PN',-24.70,-127.44,'Pitcairn Islands'),('PR',18.22,-66.59,'Puerto Rico'),('PS',31.95,35.23,'Palestinian Territories'),('PT',39.40,-8.22,'Portugal'),('PW',7.51,134.58,'Palau'),('PY',-23.44,-58.44,'Paraguay'),('QA',25.35,51.18,'Qatar'),('RE',-21.12,55.54,'Réunion'),('RO',45.94,24.97,'Romania'),('RS',44.02,21.01,'Serbia'),('RU',61.52,105.32,'Russia'),('RW',-1.94,29.87,'Rwanda'),('SA',23.89,45.08,'Saudi Arabia'),('SB',-9.65,160.16,'Solomon Islands'),('SC',-4.68,55.49,'Seychelles'),('SD',12.86,30.22,'Sudan'),('SE',60.13,18.64,'Sweden'),('SG',1.35,103.82,'Singapore'),('SH',-24.14,-10.03,'Saint Helena'),('SI',46.15,15.00,'Slovenia'),('SJ',77.55,23.67,'Svalbard and Jan Mayen'),('SK',48.67,19.70,'Slovakia'),('SL',8.46,-11.78,'Sierra Leone'),('SM',43.94,12.46,'San Marino'),('SN',14.50,-14.45,'Senegal'),('SO',5.15,46.20,'Somalia'),('SR',3.92,-56.03,'Suriname'),('ST',0.19,6.61,'São Tomé and Príncipe'),('SV',13.79,-88.90,'El Salvador'),('SY',34.80,39.00,'Syria'),('SZ',-26.52,31.47,'Swaziland'),('TC',21.69,-71.80,'Turks and Caicos Islands'),('TD',15.45,18.73,'Chad'),('TF',-49.28,69.35,'French Southern Territories'),('TG',8.62,0.82,'Togo'),('TH',15.87,100.99,'Thailand'),('TJ',38.86,71.28,'Tajikistan'),('TK',-8.97,-171.86,'Tokelau'),('TL',-8.87,125.73,'Timor-Leste'),('TM',38.97,59.56,'Turkmenistan'),('TN',33.89,9.54,'Tunisia'),('TO',-21.18,-175.20,'Tonga'),('TR',38.96,35.24,'Turkey'),('TT',10.69,-61.22,'Trinidad and Tobago'),('TV',-7.11,177.65,'Tuvalu'),('TW',23.70,120.96,'Taiwan'),('TZ',-6.37,34.89,'Tanzania'),('UA',48.38,31.17,'Ukraine'),('UG',1.37,32.29,'Uganda'),('US',37.09,-95.71,'United States'),('UY',-32.52,-55.77,'Uruguay'),('UZ',41.38,64.59,'Uzbekistan'),('VA',41.90,12.45,'Vatican City'),('VC',12.98,-61.29,'Saint Vincent and the Grenadines'),('VE',6.42,-66.59,'Venezuela'),('VG',18.42,-64.64,'British Virgin Islands'),('VI',18.34,-64.90,'U.S. Virgin Islands'),('VN',14.06,108.28,'Vietnam'),('VU',-15.38,166.96,'Vanuatu'),('WF',-13.77,-177.16,'Wallis and Futuna'),('WS',-13.76,-172.10,'Samoa'),('XK',42.60,20.90,'Kosovo'),('YE',15.55,48.52,'Yemen'),('YT',-12.83,45.17,'Mayotte'),('ZA',-30.56,22.94,'South Africa'),('ZM',-13.13,27.85,'Zambia'),('ZW',-19.02,29.15,'Zimbabwe');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_countries`
--

DROP TABLE IF EXISTS `ip_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lat` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `output` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_countries_ip_index` (`ip`),
  KEY `ip_countries_country_code_index` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=37642 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_countries`
--

LOCK TABLES `ip_countries` WRITE;
/*!40000 ALTER TABLE `ip_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `ip_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_lock`
--

DROP TABLE IF EXISTS `ip_lock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_lock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_lock`
--

LOCK TABLES `ip_lock` WRITE;
/*!40000 ALTER TABLE `ip_lock` DISABLE KEYS */;
/*!40000 ALTER TABLE `ip_lock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `json_data`
--

DROP TABLE IF EXISTS `json_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `json_data` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL,
  `json` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `json_data`
--

LOCK TABLES `json_data` WRITE;
/*!40000 ALTER TABLE `json_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `json_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markers`
--

DROP TABLE IF EXISTS `markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `markers` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reports` int(11) NOT NULL,
  `sights` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `markers_number_index` (`number`),
  KEY `markers_ip_index` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=15769 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markers`
--

LOCK TABLES `markers` WRITE;
/*!40000 ALTER TABLE `markers` DISABLE KEYS */;
/*!40000 ALTER TABLE `markers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_11_06_010226_create_jobs_table',1),('2016_07_13_204855_first',1),('2016_07_13_205308_uuid',1),('2016_07_14_214203_ip_lock_table',2),('2016_07_15_020849_users',3),('2016_07_15_201930_report',4),('2016_07_16_115206_contrylatlng',5),('2016_07_16_132741_social',6),('2016_07_16_150443_api',7),('2016_07_16_172455_api2',8),('2016_07_16_204335_reports2',9),('2016_07_17_000838_seen',10),('2016_07_17_122103_ipcountryoutput',11),('2016_07_17_122244_mylocation',11),('2016_07_17_160440_locationuuid',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pokemons`
--

DROP TABLE IF EXISTS `pokemons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pokemons` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pokemons_number_index` (`number`),
  KEY `pokemons_name_index` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokemons`
--

LOCK TABLES `pokemons` WRITE;
/*!40000 ALTER TABLE `pokemons` DISABLE KEYS */;
INSERT INTO `pokemons` VALUES (1,1,'Bulbasaur','2016-07-12 01:37:03','2016-07-12 01:37:03'),(2,2,'Ivysaur','2016-07-12 01:37:05','2016-07-12 01:37:05'),(3,3,'Venusaur','2016-07-12 01:37:10','2016-07-12 01:37:10'),(4,4,'Charmander','2016-07-12 01:37:14','2016-07-12 01:37:14'),(5,5,'Charmeleon','2016-07-12 01:37:19','2016-07-12 01:37:19'),(6,6,'Charizard','2016-07-12 01:37:21','2016-07-12 01:37:21'),(7,7,'Squirtle','2016-07-12 01:37:25','2016-07-12 01:37:25'),(8,8,'Wartortle','2016-07-12 01:37:32','2016-07-12 01:37:32'),(9,9,'Blastoise','2016-07-12 01:37:38','2016-07-12 01:37:38'),(10,10,'Caterpie','2016-07-12 01:37:41','2016-07-12 01:37:41'),(11,11,'Metapod','2016-07-12 01:37:46','2016-07-12 01:37:46'),(12,12,'Butterfree','2016-07-12 01:37:50','2016-07-12 01:37:50'),(13,13,'Weedle','2016-07-12 01:37:54','2016-07-12 01:37:54'),(14,14,'Kakuna','2016-07-12 01:38:00','2016-07-12 01:38:00'),(15,15,'Beedrill','2016-07-12 01:38:09','2016-07-12 01:38:09'),(16,16,'Pidgey','2016-07-12 01:38:14','2016-07-12 01:38:14'),(17,17,'Pidgeotto','2016-07-12 01:38:18','2016-07-12 01:38:18'),(18,18,'Pidgeot','2016-07-12 01:38:20','2016-07-12 01:38:20'),(19,19,'Rattata','2016-07-12 01:38:22','2016-07-12 01:38:22'),(20,20,'Raticate','2016-07-12 01:38:24','2016-07-12 01:38:24'),(21,21,'Spearow','2016-07-12 01:38:26','2016-07-12 01:38:26'),(22,22,'Fearow','2016-07-12 01:38:30','2016-07-12 01:38:30'),(23,23,'Ekans','2016-07-12 01:38:33','2016-07-12 01:38:33'),(24,24,'Arbok','2016-07-12 01:38:35','2016-07-12 01:38:35'),(25,25,'Pikachu','2016-07-12 01:38:38','2016-07-12 01:38:38'),(26,26,'Raichu','2016-07-12 01:38:40','2016-07-12 01:38:40'),(27,27,'Sandshrew','2016-07-12 01:38:41','2016-07-12 01:38:41'),(28,28,'Sandslash','2016-07-12 01:38:43','2016-07-12 01:38:43'),(29,29,'Nidoran-f','2016-07-12 01:38:47','2016-07-12 01:38:47'),(30,30,'Nidorina','2016-07-12 01:38:50','2016-07-12 01:38:50'),(31,31,'Nidoqueen','2016-07-12 01:38:52','2016-07-12 01:38:52'),(32,32,'Nidoran-m','2016-07-12 01:38:54','2016-07-12 01:38:54'),(33,33,'Nidorino','2016-07-12 01:38:56','2016-07-12 01:38:56'),(34,34,'Nidoking','2016-07-12 01:38:59','2016-07-12 01:38:59'),(35,35,'Clefairy','2016-07-12 01:39:02','2016-07-12 01:39:02'),(36,36,'Clefable','2016-07-12 01:39:05','2016-07-12 01:39:05'),(37,37,'Vulpix','2016-07-12 01:39:07','2016-07-12 01:39:07'),(38,38,'Ninetales','2016-07-12 01:39:09','2016-07-12 01:39:09'),(39,39,'Jigglypuff','2016-07-12 01:39:14','2016-07-12 01:39:14'),(40,40,'Wigglytuff','2016-07-12 01:39:18','2016-07-12 01:39:18'),(41,41,'Zubat','2016-07-12 01:39:20','2016-07-12 01:39:20'),(42,42,'Golbat','2016-07-12 01:39:22','2016-07-12 01:39:22'),(43,43,'Oddish','2016-07-12 01:39:26','2016-07-12 01:39:26'),(44,44,'Gloom','2016-07-12 01:39:27','2016-07-12 01:39:27'),(45,45,'Vileplume','2016-07-12 01:39:29','2016-07-12 01:39:29'),(46,46,'Paras','2016-07-12 01:39:31','2016-07-12 01:39:31'),(47,47,'Parasect','2016-07-12 01:39:35','2016-07-12 01:39:35'),(48,48,'Venonat','2016-07-12 01:39:37','2016-07-12 01:39:37'),(49,49,'Venomoth','2016-07-12 01:39:39','2016-07-12 01:39:39'),(50,50,'Diglett','2016-07-12 01:39:44','2016-07-12 01:39:44'),(51,51,'Dugtrio','2016-07-12 01:39:46','2016-07-12 01:39:46'),(52,52,'Meowth','2016-07-12 01:39:48','2016-07-12 01:39:48'),(53,53,'Persian','2016-07-12 01:39:51','2016-07-12 01:39:51'),(54,54,'Psyduck','2016-07-12 01:39:54','2016-07-12 01:39:54'),(55,55,'Golduck','2016-07-12 01:39:56','2016-07-12 01:39:56'),(56,56,'Mankey','2016-07-12 01:40:00','2016-07-12 01:40:00'),(57,57,'Primeape','2016-07-12 01:40:02','2016-07-12 01:40:02'),(58,58,'Growlithe','2016-07-12 01:40:03','2016-07-12 01:40:03'),(59,59,'Arcanine','2016-07-12 01:40:06','2016-07-12 01:40:06'),(60,60,'Poliwag','2016-07-12 01:40:09','2016-07-12 01:40:09'),(61,61,'Poliwhirl','2016-07-12 01:40:11','2016-07-12 01:40:11'),(62,62,'Poliwrath','2016-07-12 01:40:14','2016-07-12 01:40:14'),(63,63,'Abra','2016-07-12 01:40:19','2016-07-12 01:40:19'),(64,64,'Kadabra','2016-07-12 01:40:21','2016-07-12 01:40:21'),(65,65,'Alakazam','2016-07-12 01:40:23','2016-07-12 01:40:23'),(66,66,'Machop','2016-07-12 01:40:24','2016-07-12 01:40:24'),(67,67,'Machoke','2016-07-12 01:40:26','2016-07-12 01:40:26'),(68,68,'Machamp','2016-07-12 01:40:28','2016-07-12 01:40:28'),(69,69,'Bellsprout','2016-07-12 01:40:31','2016-07-12 01:40:31'),(70,70,'Weepinbell','2016-07-12 01:40:32','2016-07-12 01:40:32'),(71,71,'Victreebel','2016-07-12 01:40:33','2016-07-12 01:40:33'),(72,72,'Tentacool','2016-07-12 01:40:35','2016-07-12 01:40:35'),(73,73,'Tentacruel','2016-07-12 01:40:37','2016-07-12 01:40:37'),(74,74,'Geodude','2016-07-12 01:40:38','2016-07-12 01:40:38'),(75,75,'Graveler','2016-07-12 01:40:40','2016-07-12 01:40:40'),(76,76,'Golem','2016-07-12 01:40:41','2016-07-12 01:40:41'),(77,77,'Ponyta','2016-07-12 01:40:42','2016-07-12 01:40:42'),(78,78,'Rapidash','2016-07-12 01:40:43','2016-07-12 01:40:43'),(79,79,'Slowpoke','2016-07-12 01:40:45','2016-07-12 01:40:45'),(80,80,'Slowbro','2016-07-12 01:40:48','2016-07-12 01:40:48'),(81,81,'Magnemite','2016-07-12 01:40:52','2016-07-12 01:40:52'),(82,82,'Magneton','2016-07-12 01:40:55','2016-07-12 01:40:55'),(83,83,'Farfetchd','2016-07-12 01:40:59','2016-07-12 01:40:59'),(84,84,'Doduo','2016-07-12 01:41:03','2016-07-12 01:41:03'),(85,85,'Dodrio','2016-07-12 01:41:07','2016-07-12 01:41:07'),(86,86,'Seel','2016-07-12 01:41:11','2016-07-12 01:41:11'),(87,87,'Dewgong','2016-07-12 01:41:16','2016-07-12 01:41:16'),(88,88,'Grimer','2016-07-12 01:41:20','2016-07-12 01:41:20'),(89,89,'Muk','2016-07-12 01:41:26','2016-07-12 01:41:26'),(90,90,'Shellder','2016-07-12 01:41:31','2016-07-12 01:41:31'),(91,91,'Cloyster','2016-07-12 01:41:37','2016-07-12 01:41:37'),(92,92,'Gastly','2016-07-12 01:41:43','2016-07-12 01:41:43'),(93,93,'Haunter','2016-07-12 01:41:50','2016-07-12 01:41:50'),(94,94,'Gengar','2016-07-12 01:41:57','2016-07-12 01:41:57'),(95,95,'Onix','2016-07-12 01:42:04','2016-07-12 01:42:04'),(96,96,'Drowzee','2016-07-12 01:42:11','2016-07-12 01:42:11'),(97,97,'Hypno','2016-07-12 01:42:19','2016-07-12 01:42:19'),(98,98,'Krabby','2016-07-12 01:42:27','2016-07-12 01:42:27'),(99,99,'Kingler','2016-07-12 01:42:35','2016-07-12 01:42:35'),(100,100,'Voltorb','2016-07-12 01:42:44','2016-07-12 01:42:44'),(101,101,'Electrode','2016-07-12 01:42:53','2016-07-12 01:42:53'),(102,102,'Exeggcute','2016-07-12 01:43:01','2016-07-12 01:43:01'),(103,103,'Exeggutor','2016-07-12 01:43:11','2016-07-12 01:43:11'),(104,104,'Cubone','2016-07-12 01:43:15','2016-07-12 01:43:15'),(105,105,'Marowak','2016-07-12 01:43:17','2016-07-12 01:43:17'),(106,106,'Hitmonlee','2016-07-12 01:43:22','2016-07-12 01:43:22'),(107,107,'Hitmonchan','2016-07-12 01:43:23','2016-07-12 01:43:23'),(108,108,'Lickitung','2016-07-12 01:43:25','2016-07-12 01:43:25'),(109,109,'Koffing','2016-07-12 01:43:26','2016-07-12 01:43:26'),(110,110,'Weezing','2016-07-12 01:43:27','2016-07-12 01:43:27'),(111,111,'Rhyhorn','2016-07-12 01:43:29','2016-07-12 01:43:29'),(112,112,'Rhydon','2016-07-12 01:43:30','2016-07-12 01:43:30'),(113,113,'Chansey','2016-07-12 01:43:32','2016-07-12 01:43:32'),(114,114,'Tangela','2016-07-12 01:43:33','2016-07-12 01:43:33'),(115,115,'Kangaskhan','2016-07-12 01:43:35','2016-07-12 01:43:35'),(116,116,'Horsea','2016-07-12 01:43:36','2016-07-12 01:43:36'),(117,117,'Seadra','2016-07-12 01:43:38','2016-07-12 01:43:38'),(118,118,'Goldeen','2016-07-12 01:43:40','2016-07-12 01:43:40'),(119,119,'Seaking','2016-07-12 01:43:42','2016-07-12 01:43:42'),(120,120,'Staryu','2016-07-12 01:43:44','2016-07-12 01:43:44'),(121,121,'Starmie','2016-07-12 01:43:46','2016-07-12 01:43:46'),(122,122,'Mr-mime','2016-07-12 01:43:48','2016-07-12 01:43:48'),(123,123,'Scyther','2016-07-12 01:43:49','2016-07-12 01:43:49'),(124,124,'Jynx','2016-07-12 01:43:50','2016-07-12 01:43:50'),(125,125,'Electabuzz','2016-07-12 01:43:52','2016-07-12 01:43:52'),(126,126,'Magmar','2016-07-12 01:43:53','2016-07-12 01:43:53'),(127,127,'Pinsir','2016-07-12 01:43:54','2016-07-12 01:43:54'),(128,128,'Tauros','2016-07-12 01:43:56','2016-07-12 01:43:56'),(129,129,'Magikarp','2016-07-12 01:43:56','2016-07-12 01:43:56'),(130,130,'Gyarados','2016-07-12 01:43:57','2016-07-12 01:43:57'),(131,131,'Lapras','2016-07-12 01:43:59','2016-07-12 01:43:59'),(132,132,'Ditto','2016-07-12 01:43:59','2016-07-12 01:43:59'),(133,133,'Eevee','2016-07-12 01:44:00','2016-07-12 01:44:00'),(134,134,'Vaporeon','2016-07-12 01:44:01','2016-07-12 01:44:01'),(135,135,'Jolteon','2016-07-12 01:44:03','2016-07-12 01:44:03'),(136,136,'Flareon','2016-07-12 01:44:04','2016-07-12 01:44:04'),(137,137,'Porygon','2016-07-12 01:44:06','2016-07-12 01:44:06'),(138,138,'Omanyte','2016-07-12 01:44:07','2016-07-12 01:44:07'),(139,139,'Omastar','2016-07-12 01:44:08','2016-07-12 01:44:08'),(140,140,'Kabuto','2016-07-12 01:44:09','2016-07-12 01:44:09'),(141,141,'Kabutops','2016-07-12 01:44:10','2016-07-12 01:44:10'),(142,142,'Aerodactyl','2016-07-12 01:44:12','2016-07-12 01:44:12'),(143,143,'Snorlax','2016-07-12 01:44:13','2016-07-12 01:44:13'),(144,144,'Articuno','2016-07-12 01:44:14','2016-07-12 01:44:14'),(145,145,'Zapdos','2016-07-12 01:44:16','2016-07-12 01:44:16'),(146,146,'Moltres','2016-07-12 01:44:17','2016-07-12 01:44:17'),(147,147,'Dratini','2016-07-12 01:44:18','2016-07-12 01:44:18'),(148,148,'Dragonair','2016-07-12 01:44:19','2016-07-12 01:44:19'),(149,149,'Dragonite','2016-07-12 01:44:21','2016-07-12 01:44:21'),(150,150,'Mewtwo','2016-07-12 01:44:23','2016-07-12 01:44:23'),(151,151,'Mew','2016-07-12 01:44:26','2016-07-12 01:44:26');
/*!40000 ALTER TABLE `pokemons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `marker_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `reports_user_id_index` (`user_id`),
  KEY `reports_marker_id_index` (`marker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sights`
--

DROP TABLE IF EXISTS `sights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sights` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `marker_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `sights_user_id_index` (`user_id`),
  KEY `sights_marker_id_index` (`marker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10369 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sights`
--

LOCK TABLES `sights` WRITE;
/*!40000 ALTER TABLE `sights` DISABLE KEYS */;
/*!40000 ALTER TABLE `sights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_locations`
--

DROP TABLE IF EXISTS `user_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_locations_user_id_foreign` (`user_id`),
  KEY `user_locations_uuid_index` (`uuid`),
  CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_locations`
--

LOCK TABLES `user_locations` WRITE;
/*!40000 ALTER TABLE `user_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `social_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `network` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_network_index` (`network`)
) ENGINE=InnoDB AUTO_INCREMENT=1942 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pgo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-22  2:06:53
