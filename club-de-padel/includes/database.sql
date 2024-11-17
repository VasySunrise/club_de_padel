
CREATE DATABASE padel;

USE padel;

CREATE TABLE USUARIO (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    tipo INT NOT NULL
);

CREATE TABLE PISTA (
    id_pista INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE RESERVA (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    usuario INT NOT NULL,
    pista INT NOT NULL,
    turno INT NOT NULL,
    FOREIGN KEY (usuario) REFERENCES USUARIO(id_usuario),
    FOREIGN KEY (pista) REFERENCES PISTA(id_pista),
    UNIQUE (pista, turno)
);


DELETE FROM USUARIO WHERE nombre = 'admin';
INSERT INTO USUARIO (nombre, pass, tipo) VALUES ('admin', '$2y$10$eGKs3H52zU4NcL7o4DmezuG1k5Eq2DrWQh/cZ/UPXClVc2uPckUiq', 0);
GRANT ALL PRIVILEGES ON padel.* TO 'admin'@'localhost';
