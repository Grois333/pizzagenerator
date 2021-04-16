CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL UNIQUE,
  `password` varchar(255) CHARACTER SET ucs2 NOT NULL,
  `session` int(100) NOT NULL,
   PRIMARY KEY `id`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `pizzas`
(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `pizza_id` integer NOT NULL,
    `image` varchar(255),
    `title` varchar(255) NOT NULL,
    `ingredients` varchar(255) NOT NULL,
    `created_at` DATETIME NOT NULL
                DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY `id`(`id`),
    FOREIGN KEY(`pizza_id`) REFERENCES `users`(`id`)
);



CREATE TABLE `orders`
(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `id_of_pizza` integer NOT NULL,
    `image` varchar(255),
    `title` varchar(255) NOT NULL,
    `ingredients` varchar(255) NOT NULL,
    `customer_name` varchar(255) NOT NULL,
    `phone`varchar(255) NOT NULL,
    `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
    `comments`varchar(255) NOT NULL,
    `order_date` DATETIME NOT NULL
                DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY `id`(`id`),
    FOREIGN KEY(`id_of_pizza`) REFERENCES `pizzas`(`pizza_id`)
);



CONFIRM ORDERS (INCLUDE id_of_pizza and status)