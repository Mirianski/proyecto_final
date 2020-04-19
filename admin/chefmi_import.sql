
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
    descripcion TEXT NOT NULL,
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

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, imagen, dificultad, tiempo) 
VALUES (1,"Plato prueba 1", "Esto es un plato de ejemplo numero 1", "Ingrediente 1",
"Primer paso del pato<br />Segundo paso del pato<br />Tercer paso del pato","default.jpg",2,25);
INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, imagen, dificultad, tiempo) 
VALUES (1,"Plato prueba 2", "Esto es un plato de ejemplo numero 2", "Ingrediente 1<br />Ingrediente 2",
"Primer paso del pato<br />Segundo paso del pato","default.jpg",3,67);
INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, imagen, dificultad, tiempo) 
VALUES (2,"Plato prueba 3", "Esto es un plato de ejemplo numero 3", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato","default.jpg",1,12);

-- Carnes Entrantes Pescados Postres Vegetarianos Veganos Basicos
