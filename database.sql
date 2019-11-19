-- Create SQL database with user and a few dummy rows 
CREATE DATABASE IF NOT EXISTS kontaktformular;
use kontaktformular; 

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `anmeldungen` (`firmenname`, `anrede`, `ansprechpartner`, `telnr`, `email`, `bereich`, `teilnahmeDatum`, `tische`, `stuehle`, `anmerkung`, `vortrag`, `vortragDatum`, `vortragThema`, `vortragDauer`, `emailKopie`, `anmeldeDatum`) VALUES 
	('Microsoft Germany GmbH','Herr','Steve Ballmer','+155535687','steve.ballmer@microsoft.com','Ausbildungsbetrieb',3,1,2,'Developers, Developers, Developers!',1,'2019-11-24','Why Windows Vista wasnt that bad!',60,0,'2019-11-16 15:22:22'),
	('Google Inc.','Herr Dr.','Larry Page','+1555987654','l.page@gmail.com','Ausbildungsbetrieb',1,1,4,NULL,1,'2019-11-24','Dont be evil',10,0,'2019-11-17 14:44:54'),
	('Linux Foundation','Herr','Linus Torvalds','+196665464388','linus@hotmail.com','Sonstige',0,1,1,NULL,1,'2019-11-24','Why nvidia sucks!',30,0,'2019-11-17 15:37:26'),
	('Testfirma AG','keine Angabe','Max Mustermann','(0203) 561456','max.mustermann@domain.com','Förderverein Informatik e.V.',1,0,0,NULL,0,NULL,NULL,NULL,0,'2019-11-17 15:56:26');

CREATE TABLE `anrede` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anrede` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

INSERT INTO `anrede`(anrede) VALUES
 ('keine Angabe'),
 ('Herr'),
 ('Frau'),
 ('Herr'),
 ('Herr Dr.'),
 ('Frau Dr.'),
 ('Herr Prof.'),
 ('Frau Prof.'),
 ('Herr Prof. Dr.'),
 ('Frau Prof. Dr.');

CREATE TABLE `termine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date DEFAULT NULL,
  `wochentag` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `termine` (`datum`, `wochentag`) VALUES 
 ('2019-11-22', 'Fr.'),
 ('2019-11-23', 'Sa.'), 
 (null, 'beide Tage'); 

 CREATE USER 'form_user'@'localhost' IDENTIFIED BY 'password1';
 GRANT select, insert ON kontaktformular.anmeldungen TO 'form_user'@'localhost';
 GRANT select ON kontaktformular.termine TO 'form_user'@'localhost';
 GRANT select ON kontaktformular.anrede TO 'form_user'@'localhost';
