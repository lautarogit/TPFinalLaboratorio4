CREATE DATABASE IF NOT EXISTS TPFinalMoviePass;

USE TpFinalMoviePass;

CREATE TABLE IF NOT EXISTS users (
    userName VARCHAR(20) UNIQUE,
    `password` VARCHAR(45),
    rolId INT NOT NULL,
    firstName VARCHAR(25),
    lastName VARCHAR(25),
    dni INT NOT NULL UNIQUE,
    email VARCHAR(45),
    linkImage varchar(200),
    CONSTRAINT PK_dni PRIMARY KEY (dni)
);

SELECT * FROM users;

CREATE TABLE IF NOT EXISTS cinemas (
    id INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20),
    location VARCHAR(45),
    `status` BOOLEAN,
    CONSTRAINT PK_id PRIMARY KEY (id)

);

SELECT * FROM cinemas;

CREATE TABLE IF NOT EXISTS rooms (
    id INT NOT NULL AUTO_INCREMENT,
    idCinema INT NOT NULL,
    price FLOAT NOT NULL,
    capacity INT NOT NULL,
    `name` VARCHAR(25),
    CONSTRAINT PK_id PRIMARY KEY (id),
	CONSTRAINT FK_idCinema FOREIGN KEY (idCinema) REFERENCES cinemas (id)
);

SELECT * FROM rooms;

CREATE TABLE IF NOT EXISTS genres (
	id INT NOT NULL AUTO_INCREMENT,
	nameGenre VARCHAR(15),
	CONSTRAINT PK_idGenre PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS movies (
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(50),
	overview VARCHAR(200),
	adult BOOLEAN,
	idGenre INT NOT NULL,
	originalLanguage VARCHAR(15),
	popularity FLOAT,
	posterPath VARCHAR(50),
	releaseDate DATETIME,
	`status` BOOLEAN,
	CONSTRAINT PK_idMovie PRIMARY KEY (id),
	CONSTRAINT FK_idGenre FOREIGN KEY (idGenre) REFERENCES genres (id)
);

CREATE TABLE IF NOT EXISTS moviesXgenres (
	id INT NOT NULL AUTO_INCREMENT,
	idMovie INT NOT NULL,
	idGenre INT NOT NULL,
	CONSTRAINT PK_id PRIMARY KEY (id),
	CONSTRAINT PFK_idMovie FOREIGN KEY (idMovie) REFERENCES movies (id),
	CONSTRAINT PFK_idGenre FOREIGN KEY (idGenre) REFERENCES genres (id)	
);						

CREATE TABLE IF NOT EXISTS movieXroom (
	id INT NOT NULL AUTO_INCREMENT,
	idRoom INT NOT NULL,
	idMovie INT NOT NULL,
	showDate DATETIME,
	CONSTRAINT PK_idFunction PRIMARY KEY (id),
	CONSTRAINT PFK_idRoom FOREIGN KEY (idRoom) REFERENCES rooms (id),
	CONSTRAINT PFK_idMovie FOREIGN KEY (idMovie) REFERENCES movies (id)
);
									                             
CREATE TABLE IF NOT EXISTS tickets (
    id INT NOT NULL AUTO_INCREMENT,
    codeQR VARCHAR(200),
    idUser INT NOT NULL,
    CONSTRAINT PK_idTicket PRIMARY KEY (id),
    CONSTRAINT FK_idUser FOREIGN KEY (idUser) REFERENCES Users (id)
);