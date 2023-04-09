-- Eliminar la base de datos si existe
DROP DATABASE IF EXISTS popcorn_bucket;

-- Crear la base de datos
CREATE DATABASE popcorn_bucket;

-- Usar la base de datos
USE popcorn_bucket;

-- Crear las tablas
CREATE TABLE IF NOT EXISTS user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(100) UNIQUE,
  password CHAR(60),
  name VARCHAR(30),
  lastname VARCHAR(30)
);

CREATE TABLE IF NOT EXISTS author (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(70),
  user_id INT UNIQUE,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE IF NOT EXISTS publication_type (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) UNIQUE
);

CREATE TABLE IF NOT EXISTS publication (
  id INT PRIMARY KEY AUTO_INCREMENT,
  type_id INT,
  title VARCHAR(250),
  abstract TEXT,
  content LONGBLOB,
  publication_date DATE,
  FOREIGN KEY (type_id) REFERENCES publication_type(id)
);

CREATE TABLE IF NOT EXISTS publication_author (
  author_id INT,
  publication_id INT,
  PRIMARY KEY (author_id, publication_id),
  FOREIGN KEY (author_id) REFERENCES author(id),
  FOREIGN KEY (publication_id) REFERENCES publication(id)
);

CREATE TABLE IF NOT EXISTS category (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) UNIQUE
);

CREATE TABLE IF NOT EXISTS publication_category (
  publication_id INT,
  category_id INT,
  PRIMARY KEY (publication_id, category_id),
  FOREIGN KEY (publication_id) REFERENCES publication(id),
  FOREIGN KEY (category_id) REFERENCES category(id)
);

CREATE TABLE IF NOT EXISTS publication_reference (
  publication_id INT,
  reference_publication_id INT,
  PRIMARY KEY (publication_id, reference_publication_id),
  FOREIGN KEY (publication_id) REFERENCES publication(id),
  FOREIGN KEY (reference_publication_id) REFERENCES publication(id)
);

-- Crear un usuario con acceso completo a la base de datos
/* CREATE USER 'popcorn_blast_researcher'@'localhost' IDENTIFIED BY 'mysql';

GRANT ALL PRIVILEGES ON popcorn_bucket.* TO 'popcorn_blast_researcher'@'localhost';

FLUSH PRIVILEGES; */