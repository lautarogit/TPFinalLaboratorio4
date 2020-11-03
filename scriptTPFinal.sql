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
    CONSTRAINT PK_dni PRIMARY KEY (dni)
);

SELECT * FROM users;

CREATE TABLE IF NOT EXISTS cinemas (
    id INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20),
    location VARCHAR(45),
    `status` BOOLEAN,
    CONSTRAINT PK_id PRIMARY KEY (id),
    CONSTRAINT FK_idRoom FOREIGN KEY (idRoom) REFERENCES rooms (id)
);

SELECT * FROM cinemas;

<<<<<<< HEAD
=======

CREATE TABLE IF NOT EXISTS genres (
	id INT NOT NULL unique,
	nameGenre VARCHAR(15),
	CONSTRAINT PK_idGenre PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS movies (
	id INT NOT NULL unique,
	title VARCHAR(50),
	overview VARCHAR(200),
	adult BOOLEAN,
	originalLanguage VARCHAR(15),
	popularity FLOAT,
	posterPath VARCHAR(50),
	releaseDate DATETIME,
	`status` BOOLEAN,
    runtime int ,
	CONSTRAINT PK_idMovie PRIMARY KEY (id)
);
drop table movies;
select * from movies;
SELECT g.id,g.nameGenre FROM genres g inner join MoviesXgenres r on g.id=r.idGenre inner join movies m on r.idMovie =m.id where m.id=337401 ;
CREATE TABLE IF NOT EXISTS moviesXgenres (
	id INT NOT NULL AUTO_INCREMENT,
	idMovie INT NOT NULL,
	idGenre INT NOT NULL,
	CONSTRAINT PK_id PRIMARY KEY (id)	
);						
select * from moviesXgenres;
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
CREATE TABLE IF NOT EXISTS rooms (
    id INT NOT NULL AUTO_INCREMENT,
    idCinema INT NOT NULL,
    price FLOAT NOT NULL,
    capacity INT NOT NULL,
    `name` VARCHAR (25),
    `status` BOOLEAN,
    idShow INT NOT NULL,
    CONSTRAINT PK_id PRIMARY KEY (id),
	CONSTRAINT FK_idCinema FOREIGN KEY (idCinema) REFERENCES cinemas (id)
);

SELECT * FROM rooms;

CREATE TABLE IF NOT EXISTS shows (
	id INT NOT NULL AUTO_INCREMENT,
	idRoom INT NOT NULL,
	idMovie INT NOT NULL,
	`dateTime` DATETIME,
    remainingTickets INT NOT NULL,
	CONSTRAINT PK_id PRIMARY KEY (id)
	#CONSTRAINT PFK_idRoom FOREIGN KEY (idRoom) REFERENCES rooms (id),
	#CONSTRAINT PFK_idMovie FOREIGN KEY (idMovie) REFERENCES movies (id)
);

SELECT * FROM shows;

CREATE TABLE IF NOT EXISTS genres (
	id INT NOT NULL AUTO_INCREMENT,
	nameGenre VARCHAR(15),
	CONSTRAINT PK_id PRIMARY KEY (id)
);

SELECT * FROM genres;

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
    runtime INT,
	CONSTRAINT PK_id PRIMARY KEY (id)
	#CONSTRAINT FK_idGenre FOREIGN KEY (idGenre) REFERENCES genres (id)
);

SELECT * FROM movies;

CREATE TABLE IF NOT EXISTS moviesXgenres (
	id INT NOT NULL AUTO_INCREMENT,
	idMovie INT NOT NULL,
	idGenre INT NOT NULL,
	CONSTRAINT PK_id PRIMARY KEY (id)	
);		

SELECT * FROM moviesXgenres;				
									                             
CREATE TABLE IF NOT EXISTS tickets (
    id INT NOT NULL AUTO_INCREMENT,
    codeQR VARCHAR(200),
    idUser INT NOT NULL,
    CONSTRAINT PK_id PRIMARY KEY (id),
    CONSTRAINT FK_idUser FOREIGN KEY (idUser) REFERENCES Users (id)
);