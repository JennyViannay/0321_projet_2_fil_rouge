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