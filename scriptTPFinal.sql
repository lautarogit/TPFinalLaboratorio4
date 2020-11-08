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
    CONSTRAINT PK_id PRIMARY KEY (id)

);

SELECT * FROM cinemas;

CREATE TABLE IF NOT EXISTS rooms (
    id INT NOT NULL AUTO_INCREMENT,
    idCinema INT NOT NULL,
    price FLOAT NOT NULL,
    capacity INT NOT NULL,
    `name` VARCHAR (25),
    `status` BOOLEAN,
    idShow INT NOT NULL,
    CONSTRAINT PK_id PRIMARY KEY (id) 
);

SELECT * FROM rooms;

CREATE TABLE IF NOT EXISTS shows (
	id INT NOT NULL AUTO_INCREMENT,
	idRoom INT NOT NULL,
	idMovie INT NOT NULL,
	`dateTime` DATETIME,
    remainingTickets INT NOT NULL,
	CONSTRAINT PK_id PRIMARY KEY (id),
	CONSTRAINT PFK_idRoom FOREIGN KEY (idRoom) REFERENCES rooms (id) ON UPDATE  CASCADE,
	CONSTRAINT PFK_idMovie FOREIGN KEY (idMovie) REFERENCES movies (id) 
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
	
	originalLanguage VARCHAR(15),
	popularity FLOAT,
	posterPath VARCHAR(50),
	releaseDate DATETIME,
	`status` BOOLEAN,
    runtime INT,
	CONSTRAINT PK_id PRIMARY KEY (id)

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
   idShow int not null,
   idUser INT NOT NULL,
    CONSTRAINT PK_id PRIMARY KEY (id)
);

select * from tickets;
SELECT * FROM tickets WHERE idUser= 231231;

select * from tickets t 
inner join shows s 
on t.idshow = s.id 
inner join users  u
on t.idUser = u.dni
inner join rooms r 
on s.idRoom = r.id 
INNER JOiN cinemas c
on c.id = r.idCinema
inner join movies m on
s.idMovie = m.id
 where t.idUser = 231231; 
 ALTER TABLE tickets ADD CONSTRAINT FK_idShow FOREIGN KEY (idShow) REFERENCES shows (id);
ALTER TABLE tickets ADD CONSTRAINT FK_idUser FOREIGN KEY (idUser) REFERENCES users (dni);
 create table if not exists imageUser( idUser int not null,
										image varchar (200));
                                        ALTER TABLE tickets ADD CONSTRAINT FK_idShow FOREIGN KEY (idShow) REFERENCES shows (id);
ALTER TABLE tickets ADD CONSTRAINT FK_idUser FOREIGN KEY (idUser) REFERENCES users (dni);