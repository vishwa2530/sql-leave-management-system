CREATE DATABASE IF NOT EXISTS leave_management;
USE leave_management;

-- Drop old tables if they exist
DROP TABLE IF EXISTS leaves;
DROP TABLE IF EXISTS users;

-- Users Table (Admin & Students)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','student') NOT NULL
);

-- Leaves Table
CREATE TABLE IF NOT EXISTS leaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert Admin Account
INSERT INTO users (name, email, password, role)
VALUES ('Admin', 'admin@panimalar.com', MD5('panimalar'), 'admin');
