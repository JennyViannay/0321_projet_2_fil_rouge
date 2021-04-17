CREATE DATABASE e_shop_21;

USE e_shop_21;

CREATE TABLE `article` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` INT NOT NULL,
  `hours` INT NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `categorie` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE article ADD COLUMN categorie_id INT NOT NULL;
ALTER TABLE article ADD CONSTRAINT FK_article_categorie FOREIGN KEY (categorie_id) REFERENCES categorie(id);

CREATE TABLE `user` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `role` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE user ADD CONSTRAINT FK_user_role FOREIGN KEY (role_id) REFERENCES role(id);

CREATE TABLE `wishlist` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `user_id` int NOT NULL,
  `article_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE wishlist ADD CONSTRAINT FK_wishlist_user FOREIGN KEY (user_id) REFERENCES user(id);
ALTER TABLE wishlist ADD CONSTRAINT FK_wishlist_article FOREIGN KEY (article_id) REFERENCES article(id);