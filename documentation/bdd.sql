-- Création de la base de données
CREATE DATABASE IF NOT EXISTS mediapp;
USE mediapp;

-- Table des utilisateurs (pour la gestion de l'authentification)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des médias génériques
CREATE TABLE IF NOT EXISTS media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    type ENUM('book', 'movie', 'album') NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des livres (spécifique aux livres)
CREATE TABLE IF NOT EXISTS books (
    media_id INT PRIMARY KEY,
    page_number INT NOT NULL,
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);

-- Table des films (spécifique aux films)
CREATE TABLE IF NOT EXISTS movies (
    media_id INT PRIMARY KEY,
    duration DOUBLE NOT NULL,
    genre ENUM('Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Romance', 'Thriller', 'Documentary', 'Other') NOT NULL,
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);

-- Table des albums (spécifique aux albums)
CREATE TABLE IF NOT EXISTS albums (
    media_id INT PRIMARY KEY,
    song_number INT NOT NULL,
    editor VARCHAR(255) NOT NULL,
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);

-- Index pour la recherche rapide par titre
CREATE INDEX idx_media_titre ON media (titre);

-- Insertion d'exemples de données dans la table users
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$JRC2qhbuHqujg3CA3fknAOOINDI0dDqtzE1zY9CQ2UTSd/cZ8dGDy'), --mot de passe : password


-- Insertion d'exemples de données dans la table media
INSERT INTO media (titre, auteur, type, disponible) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', 'book', TRUE),
('To Kill a Mockingbird', 'Harper Lee', 'book', FALSE),
('1984', 'George Orwell', 'book', TRUE),
('Inception', 'Christopher Nolan', 'movie', TRUE),
('The Matrix', 'Lana Wachowski, Lilly Wachowski', 'movie', FALSE),
('Pulp Fiction', 'Quentin Tarantino', 'movie', TRUE),
('Thriller', 'Michael Jackson', 'album', FALSE),
('Abbey Road', 'The Beatles', 'album', TRUE),
('Back in Black', 'AC/DC', 'album', TRUE);

-- Insertion d'exemples de données dans la table books
INSERT INTO books (media_id, page_number) VALUES
((SELECT id FROM media WHERE titre = 'The Great Gatsby'), 180),
((SELECT id FROM media WHERE titre = 'To Kill a Mockingbird'), 281),
((SELECT id FROM media WHERE titre = '1984'), 328);

-- Insertion d'exemples de données dans la table movies
INSERT INTO movies (media_id, duration, genre) VALUES
((SELECT id FROM media WHERE titre = 'Inception'), 148, 'Sci-Fi'),
((SELECT id FROM media WHERE titre = 'The Matrix'), 136, 'Sci-Fi'),
((SELECT id FROM media WHERE titre = 'Pulp Fiction'), 154, 'Thriller');

-- Insertion d'exemples de données dans la table albums
INSERT INTO albums (media_id, song_number, editor) VALUES
((SELECT id FROM media WHERE titre = 'Thriller'), 9, 'Epic Records'),
((SELECT id FROM media WHERE titre = 'Abbey Road'), 17, 'Apple Records'),
((SELECT id FROM media WHERE titre = 'Back in Black'), 10, 'Atlantic Records');
