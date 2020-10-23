create database if not exists TPFinalMoviePass;
#drop database TPFinalMoviePass
use TpFinalMoviePass;
CREATE TABLE IF NOT EXISTS Persons (
    dni INT NOT NULL UNIQUE,
    firstName VARCHAR(15),
    lastName VARCHAR(15),
    email VARCHAR(30),
    CONSTRAINT pk_dni PRIMARY KEY (dni)
);
CREATE TABLE IF NOT EXISTS Users (
    id INT NOT NULL AUTO_INCREMENT,
    userName VARCHAR(20) UNIQUE,
    userPassword VARCHAR(20),
    dni INT NOT NULL UNIQUE,
    CONSTRAINT pk_idUser PRIMARY KEY (id),
    CONSTRAINT fk_dni FOREIGN KEY (dni)
        REFERENCES Persons (dni)
);
CREATE TABLE IF NOT EXISTS Cinemas (
    id INT NOT NULL AUTO_INCREMENT,
    nameCinema VARCHAR(20),
    location VARCHAR(20),
    CONSTRAINT pk_idCinema PRIMARY KEY (id)
);
create table if not exists TypesRooms(id int not null auto_increment,
									price int not null ,
                                    roomType varchar (15),
                                    constraint pk_idType primary key (id));
CREATE TABLE IF NOT EXISTS Rooms (
    id INT NOT NULL AUTO_INCREMENT,
    idCinema INT NOT NULL,
    idType INT NOT NULL,
    capacity INT NOT NULL,
    nameRoom INT NOT NULL,
    CONSTRAINT pk_idRoom PRIMARY KEY (id),
    CONSTRAINT fk_idType FOREIGN KEY (idType)
        REFERENCES TypesRooms (id),
    CONSTRAINT fk_idCinema FOREIGN KEY (idCinema)
        REFERENCES Cinemas (id)
);
create table if not exists Genres (id int not null auto_increment,
								nameGenre varchar (15),
                                constraint pk_idGenre primary key (id));
create table if not exists Movies(id int not null auto_increment,
						title varchar (50),
                        overview varchar (200),
                        adult boolean,
                        genresId int not null,
                        originalLanguage varchar (15),
                        popularity float,
                        posterPath varchar (50),
                        releaseDate datetime,
               /*         statusMovie */
               constraint pk_idMovie primary key (id),
               constraint fk_idGenre foreign key (genresId) references Genres (id)
               );
							
                                    /*se deberia agregar un pfk*/
CREATE TABLE IF NOT EXISTS MovieXRoom (
    id INT NOT NULL AUTO_INCREMENT,
    idRoom INT NOT NULL,
    idMovie INT NOT NULL,
    dateFunction DATETIME,
    CONSTRAINT pk_idFunction PRIMARY KEY (id),
    CONSTRAINT fk_idRoom FOREIGN KEY (idRoom)
        REFERENCES Rooms (id),
    CONSTRAINT fk_idMovie FOREIGN KEY (idMovie)
        REFERENCES Movies (id)
);
	
									
                                
								
                                
CREATE TABLE IF NOT EXISTS Tickets (
    id INT NOT NULL AUTO_INCREMENT,
    codeQR VARCHAR(200),
    idUser INT NOT NULL,
    CONSTRAINT pk_idTicket PRIMARY KEY (id),
    CONSTRAINT fk_idUser FOREIGN KEY (idUser)
        REFERENCES Users (id)
);