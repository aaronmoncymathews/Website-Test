-- FluxTerra Simworks Database Setup
-- Run this script to create the database and all tables

CREATE DATABASE IF NOT EXISTS fluxterra;
USE fluxterra;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    hours_driven FLOAT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Licenses table
CREATE TABLE licenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sim VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    track VARCHAR(255) NOT NULL,
    earned DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    simulator VARCHAR(255) NOT NULL,
    track VARCHAR(255) NOT NULL,
    car VARCHAR(255) NOT NULL,
    session_type ENUM('Practice', 'Hotlap', 'Race') NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    duration INT NOT NULL,
    assistance_services JSON,
    total_cost DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    simulator VARCHAR(255) NOT NULL,
    track VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    prize VARCHAR(255) NOT NULL,
    participants INT DEFAULT 0,
    max_participants INT NOT NULL,
    description TEXT NOT NULL,
    is_upcoming BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Friends table
CREATE TABLE friends (
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'blocked') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, friend_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (friend_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Lap times table
CREATE TABLE lap_times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sim VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    track VARCHAR(255) NOT NULL,
    lap_time TIME NOT NULL,
    recorded_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_sim_category_track (user_id, sim, category, track),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sims table
CREATE TABLE sims (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tracks table
CREATE TABLE tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sim_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    preview_url VARCHAR(500),
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sim_id) REFERENCES sims(id) ON DELETE CASCADE
);

-- Vehicle classes table
CREATE TABLE vehicle_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sim_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sim_id) REFERENCES sims(id) ON DELETE CASCADE
);

-- Cars table
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    preview_url VARCHAR(500),
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES vehicle_classes(id) ON DELETE CASCADE
);

-- Indexes for performance optimization
CREATE INDEX idx_lap_times_leaderboard ON lap_times (sim, category, track, lap_time);
CREATE INDEX idx_bookings_schedule ON bookings (booking_date, start_time);
CREATE INDEX idx_bookings_user ON bookings (user_id);
CREATE INDEX idx_events_upcoming ON events (is_upcoming, event_date);
CREATE INDEX idx_users_email ON users (email);
CREATE INDEX idx_users_username ON users (username);

-- Insert default admin user (password: admin123)
INSERT INTO users (email, username, password, role) VALUES 
('admin@fluxterra.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample sims
INSERT INTO sims (name, description) VALUES 
('Assetto Corsa Competizione', 'Official GT World Challenge game'),
('iRacing', 'Professional racing simulation'),
('rFactor 2', 'Advanced racing simulation'),
('Automobilista 2', 'Brazilian racing simulation');

-- Insert sample tracks for ACC
INSERT INTO tracks (sim_id, name, preview_url, description) VALUES 
(1, 'Monza', 'https://via.placeholder.com/400x300/003366/ffffff?text=Monza', 'Historic Italian circuit'),
(1, 'Silverstone', 'https://via.placeholder.com/400x300/003366/ffffff?text=Silverstone', 'Home of British motorsport'),
(1, 'Spa-Francorchamps', 'https://via.placeholder.com/400x300/003366/ffffff?text=Spa', 'Belgian Ardennes circuit'),
(1, 'Nürburgring', 'https://via.placeholder.com/400x300/003366/ffffff?text=Nurburgring', 'German Green Hell');

-- Insert sample vehicle classes for ACC
INSERT INTO vehicle_classes (sim_id, name, description) VALUES 
(1, 'GT3', 'Grand Touring 3 class'),
(1, 'GT4', 'Grand Touring 4 class'),
(1, 'Cup', 'Porsche Cup class');

-- Insert sample cars for GT3 class
INSERT INTO cars (class_id, name, preview_url, description) VALUES 
(1, 'Aston Martin Vantage GT3', 'https://via.placeholder.com/400x300/A9A9A9/ffffff?text=Aston+Martin', 'British GT3 car'),
(1, 'BMW M4 GT3', 'https://via.placeholder.com/400x300/A9A9A9/ffffff?text=BMW+M4', 'German GT3 car'),
(1, 'Ferrari 488 GT3', 'https://via.placeholder.com/400x300/FF0000/ffffff?text=Ferrari+488', 'Italian GT3 car'),
(1, 'Lamborghini Huracán GT3', 'https://via.placeholder.com/400x300/FF0000/ffffff?text=Lamborghini', 'Italian GT3 car'),
(1, 'Mercedes-AMG GT3', 'https://via.placeholder.com/400x300/A9A9A9/ffffff?text=Mercedes', 'German GT3 car'),
(1, 'Porsche 911 GT3 R', 'https://via.placeholder.com/400x300/FF0000/ffffff?text=Porsche+911', 'German GT3 car');

-- Insert sample events
INSERT INTO events (title, event_date, event_time, simulator, track, category, prize, max_participants, description) VALUES 
('GT3 Championship Round 1', '2024-02-15', '19:00:00', 'Assetto Corsa Competizione', 'Monza', 'GT3', '$500', 20, 'First round of our GT3 championship series'),
('Endurance Race', '2024-02-22', '18:00:00', 'Assetto Corsa Competizione', 'Spa-Francorchamps', 'GT3', '$750', 16, '3-hour endurance race at Spa'),
('Hotlap Challenge', '2024-02-28', '20:00:00', 'Assetto Corsa Competizione', 'Silverstone', 'GT3', '$250', 30, 'Fastest lap challenge with prizes');