
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

CREATE TABLE etiquetas(
    id_etiqueta INT NOT NULL AUTO_INCREMENT,
    nombre varchar(30) NOT NULL,
    imagen text NOT NULL,
    PRIMARY KEY (id_etiqueta));

CREATE TABLE platos(
    id_plato INT NOT NULL AUTO_INCREMENT,
    id_tipo INT NOT NULL,
    nombre varchar(60) NOT NULL,
    descripcion TEXT NOT NULL,
    ingredientes TEXT NOT NULL,
    preparacion TEXT NOT NULL,
    imagen TEXT,
    dificultad INT NOT NULL,
    tiempo INT NOT NULL,
    num_personas INT NOT NULL,
    PRIMARY KEY (id_plato),
    FOREIGN KEY (id_tipo) REFERENCES tipos(id_tipo));

    
CREATE TABLE etiquetas_platos(
    id_etiqueta INT NOT NULL,
    id_plato INT NOT NULL,
    PRIMARY KEY (id_etiqueta, id_plato),
    FOREIGN KEY(id_etiqueta) REFERENCES etiquetas(id_etiqueta),
    FOREIGN KEY(id_plato) REFERENCES platos(id_plato));



INSERT INTO usuarios (username, password) VALUES ("chefmi","123456");


INSERT INTO tipos (nombre) VALUES ("Entrantes");
INSERT INTO tipos (nombre) VALUES ("Basicos");
INSERT INTO tipos (nombre) VALUES ("Postres");
INSERT INTO tipos (nombre) VALUES ("Carnes");
INSERT INTO tipos (nombre) VALUES ("Pescados");
INSERT INTO tipos (nombre) VALUES ("Vegetarianos");
INSERT INTO tipos (nombre) VALUES ("Veganos");


INSERT INTO etiquetas (nombre, imagen) VALUES ("Sin Gluten", "sin_gluten.png");
INSERT INTO etiquetas (nombre, imagen) VALUES ("Vegano", "vegan.png");
INSERT INTO etiquetas (nombre, imagen) VALUES ("Vegetariano", "vegetariano.png");
INSERT INTO etiquetas (nombre, imagen) VALUES ("Intolerante lactosa", "sin_lactosa.png");


INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (1,"Plato prueba 1", "Esto es un plato de ejemplo numero 1", "Ingrediente 1",
"Primer paso del pato<br />Segundo paso del pato<br />Tercer paso del pato",2,25, 2);
INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (1,"Plato prueba 2", "Esto es un plato de ejemplo numero 2", "Ingrediente 1<br />Ingrediente 2",
"Primer paso del pato<br />Segundo paso del pato",3,67, 4);
INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 3", "Esto es un plato de ejemplo numero 3", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 4", "Esto es un plato de ejemplo numero 4", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 5", "Esto es un plato de ejemplo numero 5", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 6", "Esto es un plato de ejemplo numero 6", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 7", "Esto es un plato de ejemplo numero 7", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 8", "Esto es un plato de ejemplo numero 8", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 9", "Esto es un plato de ejemplo numero 9", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 10", "Esto es un plato de ejemplo numero 10", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 11", "Esto es un plato de ejemplo numero 11", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 12", "Esto es un plato de ejemplo numero 12", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 13", "Esto es un plato de ejemplo numero 13", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 14", "Esto es un plato de ejemplo numero 14", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 15", "Esto es un plato de ejemplo numero 15", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 16", "Esto es un plato de ejemplo numero 16", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 17", "Esto es un plato de ejemplo numero 17", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 18", "Esto es un plato de ejemplo numero 18", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 19", "Esto es un plato de ejemplo numero 19", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 20", "Esto es un plato de ejemplo numero 20", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 21", "Esto es un plato de ejemplo numero 21", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 22", "Esto es un plato de ejemplo numero 22", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, dificultad, tiempo, num_personas) 
VALUES (2,"Plato prueba 23", "Esto es un plato de ejemplo numero 23", "Ingrediente 1<br />Ingrediente 2<br />Ingrediente 3",
"Primer paso del pato",1,12, 1);

INSERT INTO `platos` VALUES (24,5,'Merluza al horno a las finas hierbas','La merluza es un pescado blanco de carne y sabor suave por lo que casi siempre suele gustar a todos. Tiene un aporte calórico muy bajo (unas 65 Kcal y solo 2 g de grasa cada 100 g de porción comestible). También es rica en proteínas completas o de alto valor biológico. Además posee diferentes minerales y vitaminas, entre las que destacan las del grupo B.','1 merluza<br />\r\nPatatas<br />\r\n2 tomates<br />\r\n2 cebollas<br />\r\nSal<br />\r\nUn chorrito de vino blanco<br />\r\nAceite de oliva virgen extra','Lavamos muy bien las patatas, con la ayuda de un cepillo. Las cortamos a la mitad, las ponemos en un cuenco apto para microondas, y las cocinamos a máxima potencia por 5 minutos. Si no tenéis microondas, podéis hervirlas por unos 15 minutos.<br />\r\n<br />\r\nCortamos la cebolla en juliana y rallamos el tomate (o lo trituramos).<br />\r\n<br />\r\nPedimos en la pescadería que nos limpien la merluza, le quitarán las escamas, las tripas…pero que la dejen entera.<br />\r\n<br />\r\nLa lavamos un poco y ponemos en la bandeja del horno. Disponemos las patatas alrededor de la merluza. Añadimos la cebolla cortada en juliana fina, el tomate rallado, el chorrito de vino, un poco de sal y un chorreón generoso de aceite de oliva virgen extra.<br />\r\n<br />\r\nIntroducimos la bandeja en el horno precalentado a 180º C entre 20 y 30 minutos. A mitad de la cocción me gusta poner sobre la merluza parte del jugo. Debemos comprobar que la merluza y las patatas estén cocinadas pero con cuidado de que no se nos pase el pescado porque entonces podría quedar seco.<br />\r\n<br />\r\n¡Ya nos contaréis qué tal os queda esta merluza al horno!','1366_2000.jpg',2,85,1),(25,6,'berenjena rellena','berenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellena','berenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellena','berenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellenaberenjena rellena','berenjena rellena.jpg',2,230,2);


INSERT INTO etiquetas_platos (id_etiqueta, id_plato) VALUES (1, 2);
INSERT INTO etiquetas_platos (id_etiqueta, id_plato) VALUES (2, 2);
INSERT INTO etiquetas_platos (id_etiqueta, id_plato) VALUES (1, 3);

-- Carnes Entrantes Pescados Postres Vegetarianos Veganos Basicos
