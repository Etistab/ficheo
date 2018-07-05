CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `author` int(11) DEFAULT NULL,
  `dateCom` timestamp(1) NULL DEFAULT NULL,
  `sheets` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `sheets` (`sheets`)
);

CREATE TABLE `markcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark` varchar(45) DEFAULT NULL,
  `dateMark` timestamp(1) NULL DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments` (`comments`),
  KEY `fk_idUser` (`idUser`)
);

CREATE TABLE `marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark` int(11) DEFAULT NULL,
  `dateMark` timestamp(1) NULL DEFAULT NULL,
  `sheet` int(11) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sheet` (`sheet`),
  KEY `fk_idUser` (`idUser`)
);

CREATE TABLE `questionquizz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text,
  `answer` varchar(128) DEFAULT NULL,
  `choice1` varchar(128) DEFAULT NULL,
  `choice2` varchar(128) DEFAULT NULL,
  `choice3` varchar(128) DEFAULT NULL,
  `quizz` int(11) DEFAULT NULL,
  `modif` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `quizz` (`quizz`)
);

CREATE TABLE `quizmarks` (
  `users` int(11) NOT NULL,
  `quiz` int(11) NOT NULL,
  `mark` int(11) DEFAULT NULL,
  PRIMARY KEY (`users`,`quiz`)
);

CREATE TABLE `quizz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `date_crea` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auteur` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `tableReferences` varchar(20) NOT NULL,
  `idReferences` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `sheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `content` text,
  `active` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `category` varchar(128) DEFAULT NULL,
  `discipline` varchar(128) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `category` (`category`)
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `pseudo` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `date` timestamp(1) NULL DEFAULT NULL,
  `lastConnection` timestamp(1) NULL DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `reports` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);