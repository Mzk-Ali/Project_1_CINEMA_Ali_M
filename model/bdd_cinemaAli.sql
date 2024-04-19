-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema_ali
CREATE DATABASE IF NOT EXISTS `cinema_ali` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema_ali`;

-- Listage de la structure de table cinema_ali. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `acteur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.acteur : ~8 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(5, 3),
	(1, 4),
	(2, 5),
	(3, 6),
	(4, 7),
	(6, 8),
	(7, 9),
	(8, 10);

-- Listage de la structure de table cinema_ali. contrat
CREATE TABLE IF NOT EXISTS `contrat` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_acteur`,`id_role`),
  KEY `id_acteur` (`id_acteur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `contrat_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `contrat_ibfk_2` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `contrat_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.contrat : ~9 rows (environ)
INSERT INTO `contrat` (`id_film`, `id_acteur`, `id_role`) VALUES
	(2, 1, 3),
	(2, 2, 4),
	(3, 3, 1),
	(3, 4, 2),
	(4, 5, 5),
	(5, 5, 1),
	(4, 6, 2),
	(5, 7, 5),
	(1, 8, 1);

-- Listage de la structure de table cinema_ali. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `duree` int DEFAULT NULL,
  `synopsis` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin,
  `note` float DEFAULT NULL,
  `affiche_film` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT 'https://previews.123rf.com/images/shtanzman/shtanzman1310/shtanzman131000002/23112506-cin%C3%A9ma-et-le-concept-de-l-industrie-vid%C3%A9o-conseil-d-ardoise-et-de-bobine-de-film-image-de-synth%C3%A8se.jpg',
  `id_realisateur` int DEFAULT NULL,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.film : ~5 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `date_sortie`, `duree`, `synopsis`, `note`, `affiche_film`, `id_realisateur`) VALUES
	(1, 'Elan Formation', '2023-02-26', 136, 'Fait une formation sans pr&eacute;c&egrave;dent', 4, 'https://www.kindpng.com/picc/m/71-716889_question-mark-bracket-clip-art-man-sitting-on.png', 1),
	(2, 'Jurassic Park', '1993-10-20', 122, 'Se font courser par des dinosaures', 4.2, 'https://fr.web.img2.acsta.net/c_310_420/pictures/20/07/21/16/53/1319265.jpg', 2),
	(3, 'Indiana Jones et la Derni&egrave;re Croisade', '1989-10-18', 127, 'Cherche l&#039;aventure et les probl&egrave;mes\r\nEn 1912 dans l&#039;Utah, Indiana Jones, adolescent, surprend des pilleurs de tr&eacute;sors arch&eacute;ologiques avant d&#039;&ecirc;tre poursuivi par les trafiquants. 26 ans plus tard, Jones apprend que son p&egrave;re, le professeur Henry Jones, parti &agrave; la recherche du Saint Graal, a disparu et il se rend alors &agrave; Venise o&ugrave; son p&egrave;re a &eacute;t&eacute; vu pour la derni&egrave;re fois.', 3.5, 'https://fr.web.img5.acsta.net/c_310_420/medias/nmedia/18/65/88/40/18895516.jpg', 2),
	(4, 'Gran Torino', '2009-02-25', 116, 'Un veteran a des probl&egrave;mes de voisinage.\r\nWalt Kowalski est un ancien de la guerre de Cor&eacute;e, un homme inflexible, amer et p&eacute;tri de pr&eacute;jug&eacute;s surann&eacute;s. Apr&egrave;s des ann&eacute;es de travail &agrave; la cha&icirc;ne, il vit repli&eacute; sur lui-m&ecirc;me, occupant ses journ&eacute;es &agrave; bricoler, tra&icirc;nasser et siroter des bi&egrave;res. Avant de mourir, sa femme exprima le voeu qu&#039;il aille &agrave; confesse, mais Walt n&#039;a rien &agrave; avouer, ni personne &agrave; qui parler. Hormis sa chienne Daisy, il ne fait confiance qu&#039;&agrave; son M-1, toujours propre, toujours pr&ecirc;t &agrave; l&#039;usage...\r\n\r\nSes anciens voisins ont d&eacute;m&eacute;nag&eacute; ou sont morts depuis longtemps. Son quartier est aujourd&#039;hui peupl&eacute; d&#039;immigrants asiatiques qu&#039;il m&eacute;prise, et Walt ressasse ses haines, innombrables - &agrave; l&#039;encontre de ses voisins, des ados Hmong, latinos et afro-am&eacute;ricains &quot;qui croient faire la loi&quot;, de ses propres enfants, devenus pour lui des &eacute;trangers. Walt tue le temps comme il peut, en attendant le grand d&eacute;part, jusqu&#039;au jour o&ugrave; un ado Hmong du quartier tente de lui voler sa pr&eacute;cieuse Ford Gran Torino... Walt tient comme &agrave; la prunelle de ses yeux &agrave; cette voiture f&eacute;tiche, aussi belle que le jour o&ugrave; il la vit sortir de la cha&icirc;ne.', 3.9, 'https://fr.web.img4.acsta.net/c_310_420/medias/nmedia/18/67/90/93/19057560.jpg', 3),
	(5, 'Le bon, la Brute et le Truand', '1968-03-08', 180, '3 personnes cherchent le tr&eacute;sor.\r\nPendant la Guerre de S&eacute;cession, trois hommes, pr&eacute;f&eacute;rant s&#039;int&eacute;resser &agrave; leur profit personnel, se lancent &agrave; la recherche d&#039;un coffre contenant 200 000 dollars en pi&egrave;ces d&#039;or vol&eacute;s &agrave; l&#039;arm&eacute;e sudiste. Tuco sait que le tr&eacute;sor se trouve dans un cimeti&egrave;re, tandis que Joe conna&icirc;t le nom inscrit sur la pierre tombale qui sert de cache. Chacun a besoin de l&#039;autre. Mais un troisi&egrave;me homme entre dans la course : Setenza, une brute qui n&#039;h&eacute;site pas &agrave; massacrer femmes et enfants pour parvenir &agrave; ses fins.', 4.7, 'https://fr.web.img6.acsta.net/c_310_420/pictures/14/09/23/10/28/237103.jpg', 3);

-- Listage de la structure de table cinema_ali. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `genre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.genre : ~3 rows (environ)
INSERT INTO `genre` (`id_genre`, `genre`) VALUES
	(1, 'Science-fiction'),
	(2, 'Aventure'),
	(3, 'Action');

-- Listage de la structure de table cinema_ali. gestion_genre
CREATE TABLE IF NOT EXISTS `gestion_genre` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `gestion_genre_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `gestion_genre_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.gestion_genre : ~5 rows (environ)
INSERT INTO `gestion_genre` (`id_film`, `id_genre`) VALUES
	(2, 1),
	(1, 2),
	(3, 2),
	(4, 3),
	(5, 3);

-- Listage de la structure de table cinema_ali. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `sexe` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `profil` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg',
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.personne : ~10 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `date_naissance`, `profil`) VALUES
	(1, 'MARZAK', 'Ali', 'Masculin', '1997-11-30', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTgzWVbRgqzcKa5W8URScnVUE499sHlLqmDVN43iaoKvw&s'),
	(2, 'SPIELBERG', 'Steven', 'Masculin', '1946-12-18', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/MKr25425_Steven_Spielberg_%28Berlinale_2023%29.jpg/1200px-MKr25425_Steven_Spielberg_%28Berlinale_2023%29.jpg'),
	(3, 'EASTWOOD', 'Clint', 'Masculin', '1930-05-31', 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/ClintEastwoodCannesMay08.jpg/800px-ClintEastwoodCannesMay08.jpg'),
	(4, 'GOLDBLUM', 'Jeff', 'Masculin', '1952-10-22', 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg'),
	(5, 'DERN', 'Laura', 'Feminin', '1967-02-10', 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg'),
	(6, 'FORD', 'Harrison', 'Masculin', '1942-07-13', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Harrison_Ford_by_Gage_Skidmore_2.jpg/1200px-Harrison_Ford_by_Gage_Skidmore_2.jpg'),
	(7, 'DOODY', 'Alison', 'Feminin', '1966-03-09', 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg'),
	(8, 'HER', 'Ahney', 'Feminin', '1993-07-13', 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg'),
	(9, 'WALLACH', 'Eli', 'Masculin', '1915-12-07', 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg'),
	(10, 'SMAIL', 'Stephane', 'Masculin', '1985-12-10', 'https://st3.depositphotos.com/3581215/18899/v/450/depositphotos_188994514-stock-illustration-vector-illustration-male-silhouette-profile.jpg');

-- Listage de la structure de table cinema_ali. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.realisateur : ~3 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 1),
	(2, 2),
	(3, 3);

-- Listage de la structure de table cinema_ali. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom_personnage` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_ali.role : ~5 rows (environ)
INSERT INTO `role` (`id_role`, `nom_personnage`) VALUES
	(1, 'Indiana Jones'),
	(2, 'Maria Jones'),
	(3, 'Marc Foul'),
	(4, 'Stephanie Foul'),
	(5, 'Clint Torino');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
