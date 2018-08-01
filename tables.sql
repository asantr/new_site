CREATE TABLE `comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `story` int(11) DEFAULT NULL,
 `author` varchar(50) DEFAULT NULL,
 `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `content` varchar(350) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `author` (`author`),
 KEY `story` (`story`),
 CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`username`),
 CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`story`) REFERENCES `stories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8

CREATE TABLE `private_comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `story` int(11) DEFAULT NULL,
 `author` varchar(50) DEFAULT NULL,
 `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `content` varchar(350) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `author` (`author`),
 KEY `stories` (`story`),
 CONSTRAINT `stories` FOREIGN KEY (`story`) REFERENCES `private_stories` (`id`),
 CONSTRAINT `private_comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8

CREATE TABLE `private_stories` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `author` varchar(50) DEFAULT NULL,
 `user_to` varchar(50) DEFAULT NULL,
 `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `title` varchar(300) DEFAULT NULL,
 `content` varchar(800) DEFAULT NULL,
 `link` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `author` (`author`),
 CONSTRAINT `private_stories_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8

CREATE TABLE `shares` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `story` int(11) DEFAULT NULL,
 `user_to` varchar(50) DEFAULT NULL,
 `user_from` varchar(50) DEFAULT NULL,
 `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `user_to` (`user_to`),
 KEY `story` (`story`),
 CONSTRAINT `shares_ibfk_1` FOREIGN KEY (`user_to`) REFERENCES `users` (`username`),
 CONSTRAINT `shares_ibfk_2` FOREIGN KEY (`story`) REFERENCES `stories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8

CREATE TABLE `stories` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `author` varchar(50) DEFAULT NULL,
 `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `title` varchar(300) DEFAULT NULL,
 `content` varchar(800) DEFAULT NULL,
 `link` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `author` (`author`),
 CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8

CREATE TABLE `users` (
 `username` varchar(20) NOT NULL DEFAULT '',
 `password` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8