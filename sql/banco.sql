CREATE DATABASE qr_restaurantes;
USE qr_restaurantes;


CREATE TABLE empresas (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
email VARCHAR(100),
senha VARCHAR(255)
);


CREATE TABLE produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
empresa_id INT,
nome VARCHAR(100),
preco DECIMAL(10,2)
);


CREATE TABLE mesas (
id INT AUTO_INCREMENT PRIMARY KEY,
empresa_id INT,
numero_mesa INT,
token VARCHAR(100)
);


CREATE TABLE pedidos (
id INT AUTO_INCREMENT PRIMARY KEY,
empresa_id INT,
mesa INT,
nome_cliente VARCHAR(100),
itens TEXT
);