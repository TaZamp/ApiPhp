CREATE DATABASE restaurant_menu_system
;

USE estaurant_menu_system;

CREATE TABLE dish (
    dishId INT AUTO_INCREMENT PRIMARY KEY,
    dishName VARCHAR(255) NOT NULL,
    dishDescription TEXT NOT NULL,
    dishPrice DECIMAL(10, 2) NOT NULL,
    dishAvailability TINYINT(1) NOT NULL DEFAULT 1,
    dishCategory VARCHAR(255) NOT NULL,
    discount DECIMAL(5, 2) NOT NULL DEFAULT 0.00
);
