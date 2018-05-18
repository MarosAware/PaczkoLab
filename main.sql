DROP DATABASE IF EXISTS packages;
CREATE DATABASE IF NOT EXISTS packages;
USE packages;

CREATE TABLE size(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  size VARCHAR(8) UNIQUE NOT NULL,
  price DECIMAL(10,2) NOT NULL
);

INSERT INTO size (size, price) VALUES ('M',10),('XL',12),('S',5);