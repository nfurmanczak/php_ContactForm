CREATE TABLE `anmeldungen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firmenname` varchar(100) NOT NULL DEFAULT '',
  `anrede` varchar(12) NOT NULL DEFAULT '',
  `ansprechpartner` varchar(60) NOT NULL DEFAULT '',
  `telnr` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `bereich` varchar(45) NOT NULL DEFAULT '',
  `teilnahmeDatum` smallint(6) NOT NULL,
  `tische` smallint(1) NOT NULL DEFAULT '0',
  `stuehle` smallint(1) NOT NULL DEFAULT '0',
  `anmerkung` varchar(200) DEFAULT NULL,
  `vortrag` tinyint(4) NOT NULL DEFAULT '0',
  `vortragDatum` date DEFAULT NULL,
  `vortragThema` varchar(50) DEFAULT NULL,
  `vortragDauer` smallint(6) DEFAULT NULL,
  `emailKopie` tinyint(4) DEFAULT '0',
  `anmeldeDatum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `anrede` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anrede` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `termine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date DEFAULT NULL,
  `wochentag` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
