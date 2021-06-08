CREATE DATABASE IF NOT EXISTS jesuitas DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE jesuitas;

-- Estructura tabla Lugar
CREATE TABLE Lugar(
                        IdLugar tinyint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        Nombre varchar(50)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
CREATE UNIQUE INDEX NombreLugar ON Lugar (Nombre);

-- Estructura tabla Alumno
CREATE TABLE Alumno(
                      IdAlumno tinyint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      Nombre varchar(30),
                      Apellidos varchar(80)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
CREATE UNIQUE INDEX NombreApellidos ON Alumno (Nombre, Apellidos);

-- Estructura tabla Administrador
CREATE TABLE Usuario(
                    IdUser tinyint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Usuario varchar(30),
                    Pass varchar(255),
                    Tipo bit DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
CREATE UNIQUE INDEX UserAdmin ON Usuario (Usuario);

-- Estructura tabla Maquina
CREATE TABLE Maquina(
                      Ip varchar(15) NOT NULL PRIMARY KEY,
                      IdLugar tinyint unsigned ,
                      Jesuita varchar(50),
                      Firma varchar(250),
                      IdAlumno tinyint unsigned,
                      CONSTRAINT Lugar FOREIGN KEY (IdLugar) REFERENCES Lugar(IdLugar) ON DELETE CASCADE,
                      CONSTRAINT Alumno FOREIGN KEY (IdAlumno) REFERENCES Alumno(IdAlumno) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
CREATE UNIQUE INDEX lugarmaquina ON Maquina (IdLugar);
CREATE UNIQUE INDEX jesuitamaquina ON Maquina (Jesuita);

-- Estructura tabla Visita
CREATE TABLE Visita(
                        IdVisita smallint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        IpLugar varchar(15),
                        IpJesuita varchar(15),
                        FechaHora date,
                        CONSTRAINT ipLugar FOREIGN KEY (IpLugar) REFERENCES Maquina(Ip) ON DELETE CASCADE,
                        CONSTRAINT ipAlumno FOREIGN KEY (IpJesuita) REFERENCES Maquina(Ip) ON DELETE CASCADE,
                        CONSTRAINT CHK_IP CHECK (IpLugar<>IpJesuita)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
CREATE UNIQUE INDEX ipvisita ON Visita (IpLugar,IpJesuita);
