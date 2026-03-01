CREATE DATABASE IF NOT EXISTS airport CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE airport;

CREATE TABLE flights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_type ENUM('departure', 'arrival') NOT NULL,
    flight_date DATE NOT NULL,
    flight_time TIME NOT NULL,
    airport VARCHAR(100) NOT NULL,
    airline VARCHAR(100) NOT NULL,
    flight_number VARCHAR(20) NOT NULL,
    status_text VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (flight_type, flight_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
INSERT INTO flights (flight_type, flight_date, flight_time, airport, airline, flight_number, status_text) VALUES
('departure', CURDATE(), '09:10', 'Москва (ДМД)', 'S7', 'S71881', 'Рейс вылетел в 09:12'),
('departure', CURDATE(), '10:05', 'Москва (ШРМ)', 'Аэрофлот', 'AFL1531', 'Начало посадки в 10:12'),
('departure', CURDATE(), '12:10', 'С.Петербург', 'Россия', 'SDM8112', 'Регистрация с 10:00 на стойке 3'),
('departure', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:30', 'Казань', 'Победа', 'PBD123', 'Рейс вылетел в 08:35'),
('departure', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '14:20', 'Екатеринбург', 'Уральские авиалинии', 'UAL456', 'Ожидается'),

('arrival', CURDATE(), '08:45', 'Москва (ДМД)', 'S7', 'S71882', 'Совершил посадку в 08:50'),
('arrival', CURDATE(), '11:20', 'Москва (ШРМ)', 'Аэрофлот', 'AFL1532', 'Ожидается в 11:25'),
('arrival', CURDATE(), '13:40', 'С.Петербург', 'Россия', 'SDM8113', 'В пути'),
('arrival', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '09:15', 'Новосибирск', 'Сибирь', 'SBI789', 'Совершил посадку в 09:20'),
('arrival', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '16:30', 'Сочи', 'Ред Вингс', 'RWZ567', 'Ожидается');