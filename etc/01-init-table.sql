CREATE TABLE `usertypes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `users` (
  `id` int  NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usertype_id` int NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE users ADD UNIQUE(username);
ALTER TABLE users ADD CONSTRAINT FK_users_usertype FOREIGN KEY (usertype_id) REFERENCES usertypes(id);

INSERT INTO `usertypes` VALUES (1,'admin','2012-07-28 17:06:14','2012-07-28 17:06:14');
INSERT INTO `users` VALUES (1,'admin','Admin','Admin','lemoine.benoit@gmail.com','4e269209a2005329a33f0c7e3bc7b0e6631b294d',1,'2012-07-28 17:06:14','2012-07-28 17:06:14');