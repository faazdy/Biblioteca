CREATE TABLE Libros (
    idLibro INT AUTO_INCREMENT PRIMARY KEY,
    nombreLibro VARCHAR(100) NOT NULL,
    genero VARCHAR(100),
    autor VARCHAR(100)
);

CREATE TABLE Usuarios (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(250) NOT NULL,
    pass VARCHAR(250) NOT NULL,
    isAdmin TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE Prestamos (
    idPrestamo INT AUTO_INCREMENT PRIMARY KEY,
    idLibro INT NOT NULL,
    idUsuario INT NOT NULL,

    FOREIGN KEY (idLibro) REFERENCES Libros (idLibro) ON DELETE CASCADE,
    FOREIGN KEY (idUsuario) REFERENCES Usuarios (idUsuario) ON DELETE CASCADE
);

INSERT INTO Libros (nombreLibro, genero, autor) VALUES
('Cien años de soledad', 'Realismo mágico', 'Gabriel García Márquez'),
('1984', 'Distopía', 'George Orwell'),
('El principito', 'Fábula', 'Antoine de Saint-Exupéry'),
('Drácula', 'Terror', 'Bram Stoker'),
('Los juegos del hambre', 'Ciencia ficción', 'Suzanne Collins');
