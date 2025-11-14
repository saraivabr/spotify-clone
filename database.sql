-- Spotify Clone Database Schema
-- Created by analyzing PHP classes

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    signUpDate DATE NOT NULL,
    profilePic VARCHAR(500) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (username),
    UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Artists table
CREATE TABLE IF NOT EXISTS artists (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Albums table
CREATE TABLE IF NOT EXISTS albums (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    artist INT NOT NULL,
    genre VARCHAR(255) NOT NULL,
    artworkPath VARCHAR(500) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (artist) REFERENCES artists(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Songs table
CREATE TABLE IF NOT EXISTS songs (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    artist INT NOT NULL,
    album INT NOT NULL,
    genre VARCHAR(255) NOT NULL,
    duration VARCHAR(10) NOT NULL,
    path VARCHAR(500) NOT NULL,
    albumOrder INT NOT NULL DEFAULT 0,
    plays INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (artist) REFERENCES artists(id),
    FOREIGN KEY (album) REFERENCES albums(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Playlists table
CREATE TABLE IF NOT EXISTS playlists (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    owner VARCHAR(255) NOT NULL,
    dateCreated DATETIME NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Playlist Songs (junction table)
CREATE TABLE IF NOT EXISTS playlistSongs (
    id INT NOT NULL AUTO_INCREMENT,
    songId INT NOT NULL,
    playlistId INT NOT NULL,
    playlistOrder INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (songId) REFERENCES songs(id) ON DELETE CASCADE,
    FOREIGN KEY (playlistId) REFERENCES playlists(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample artists
INSERT INTO artists (name) VALUES
('Various Artists'),
('Acoustic Dreams'),
('Electronic Vibes'),
('Pop Sensation');

-- Insert sample albums
INSERT INTO albums (title, artist, genre, artworkPath) VALUES
('Clear Day Collection', 1, 'Acoustic', 'assets/images/artwork/clearday.jpg'),
('Energy Beats', 3, 'Electronic', 'assets/images/artwork/energy.jpg'),
('Funky Element', 1, 'Funk', 'assets/images/artwork/funkyelement.jpg'),
('Going Higher', 2, 'Pop', 'assets/images/artwork/goinghigher.jpg'),
('Pop Dance Party', 4, 'Pop', 'assets/images/artwork/popdance.jpg'),
('Sweet Melodies', 2, 'Acoustic', 'assets/images/artwork/sweet.jpg'),
('Ukulele Sunrise', 2, 'Acoustic', 'assets/images/artwork/ukulele.jpg');

-- Insert sample songs
INSERT INTO songs (title, artist, album, genre, duration, path, albumOrder, plays) VALUES
('Acoustic Breeze', 2, 1, 'Acoustic', '2:39', 'assets/music/clearday.mp3', 1, 0),
('Energy Wave', 3, 2, 'Electronic', '3:15', 'assets/music/energy.mp3', 1, 0),
('Funky Groove', 1, 3, 'Funk', '2:55', 'assets/music/funkyelement.mp3', 1, 0),
('Rising Up', 2, 4, 'Pop', '3:42', 'assets/music/goinghigher.mp3', 1, 0),
('Dance Floor', 4, 5, 'Pop', '3:28', 'assets/music/popdance.mp3', 1, 0),
('Sweet Harmony', 2, 6, 'Acoustic', '2:48', 'assets/music/sweet.mp3', 1, 0),
('Island Vibes', 2, 7, 'Acoustic', '3:01', 'assets/music/ukulele.mp3', 1, 0);
