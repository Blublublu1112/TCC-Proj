-- SQL script to create the leave_system database and tables
-- Run this in phpMyAdmin or MySQL command line

CREATE DATABASE IF NOT EXISTS leave_system;
USE leave_system;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('employee', 'manager') DEFAULT 'employee'
);

-- Create leaves table
CREATE TABLE IF NOT EXISTS leaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reason TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert example data
-- Note: Passwords are hashed using Werkzeug. For 'admin123', generate hash with:
-- python -c "from werkzeug.security import generate_password_hash; print(generate_password_hash('admin123'))"
-- Replace the placeholder below with the actual hash
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@example.com', 'pbkdf2:sha256:600000$l6gR3rRgwEoJA1vD$02d91cc63e8322c51817f9a5db942e37df1aeb04286974952542d21d4316b9fc', 'manager'),
('John Doe', 'john@example.com', 'pbkdf2:sha256:600000$cUVuG8q943EKGdUr$42667815a07e6f17c331b37865c9073d28c24b2bbce93f6273a721cd64f92c81', 'employee'),
('Jane Smith', 'jane@example.com', 'pbkdf2:sha256:600000$cUVuG8q943EKGdUr$42667815a07e6f17c331b37865c9073d28c24b2bbce93f6273a721cd64f92c81', 'employee');

-- Insert example leave applications
INSERT INTO leaves (user_id, start_date, end_date, reason, status) VALUES
(2, '2023-12-25', '2023-12-26', 'Christmas holiday', 'approved'),
(3, '2024-01-15', '2024-01-20', 'Family vacation', 'pending');