DROP TABLE IF EXISTS notas;
CREATE TABLE notas (
    id int,
    nombre varchar(40),
    grado int,
    num_premios int,
    programa varchar(20),
    puntaje_mat int,
    puntaje_ing int,
    puntaje_ciencias int,
    primary key(id)
);

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id int,
    nombre varchar(40),
    grado int,
    clave varchar(6),
    rol varchar(20),
    primary key(id)
);


INSERT INTO notas (id, nombre, grado, num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias) VALUES
(2, 'Ana Quintero', 10, 10, 2, 85, 78, 92),
(3, 'María Fernanda Tello', 11, 11, 1, 90, 82, 88),
(4, 'Sebastian Belalcazar', 10, 9, 0, 90, 90, 80),
(5, 'Lewis Hamilton', 9, 10, 3, 88, 85, 91),
(6, 'Carlos Sainz', 8, 12, 2, 80, 87, 90);

INSERT INTO usuarios (id, nombre, grado, clave, rol) VALUES
(1, 'Admin',NULL, 'admin', 'Administrador'),
(2, 'Ana Quintero', 10, '1234', 'Estudiante'),
(3, 'María Fernanda Tello', 11, '1234', 'Estudiante'),
(4, 'Sebastian Belalcazar', 10, '1234', 'Estudiante'),
(5, 'Lewis Hamilton', 9, 10, 3, 88, 85, 91),
(6, 'Carlos Sainz', 8, 12, 2, 80, 87, 90);
(7, 'Toto Wolff', '1234', 11, 'Profesor');