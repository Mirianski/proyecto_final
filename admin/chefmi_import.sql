
DROP DATABASE IF EXISTS chefmi;
CREATE DATABASE chefmi;

USE chefmi;

CREATE TABLE usuarios(
    id_usuario INT NOT NULL AUTO_INCREMENT,
    username varchar(30) NOT NULL,
    password varchar(30) NOT NULL,
    PRIMARY KEY (id_usuario));


CREATE TABLE tipos(
    id_tipo INT NOT NULL AUTO_INCREMENT,
    nombre varchar(30) NOT NULL,
    PRIMARY KEY (id_tipo));


CREATE TABLE platos(
    id_plato INT NOT NULL AUTO_INCREMENT,
    id_tipo INT NOT NULL,
    nombre varchar(60) NOT NULL,
    ingredientes TEXT NOT NULL,
    preparacion TEXT NOT NULL,
    imagen TEXT NOT NULL,
    dificultad INT NOT NULL,
    tiempo INT NOT NULL,
    PRIMARY KEY (id_plato),
    FOREIGN KEY (id_tipo) REFERENCES tipos(id_tipo));


INSERT INTO usuarios (username, password) VALUES ("chefmi","123456");
INSERT INTO tipos (nombre) VALUES ("Entrantes");
INSERT INTO tipos (nombre) VALUES ("Basicos");
INSERT INTO tipos (nombre) VALUES ("Postres");
INSERT INTO tipos (nombre) VALUES ("Carnes");
INSERT INTO tipos (nombre) VALUES ("Pescados");
INSERT INTO tipos (nombre) VALUES ("Vegetarianos");
INSERT INTO tipos (nombre) VALUES ("Veganos");
INSERT INTO platos (id_tipo, nombre, ingredientes, preparacion, imagen, dificultad, tiempo) VALUES (1,"Test","ingredientes","pasos","",1,20)

-- Carnes Entrantes Pescados Postres Vegetarianos Veganos Basicos
