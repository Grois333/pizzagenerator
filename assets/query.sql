CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET ucs2 NOT NULL,
  `session` int(100) NOT NULL,
   PRIMARY KEY `id`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;