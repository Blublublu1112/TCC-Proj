-- SQL script to create database and table for Simple Online Item Management
-- Run this script in your MySQL client (e.g., phpMyAdmin, MySQL Workbench, or CLI).

-- 1. Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS tcc_db;

-- 2. Select the database
USE tcc_db;

-- 3. Create the items table
CREATE TABLE IF NOT EXISTS items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- (Optional) Insert some dummy data for testing
INSERT INTO items (name, description, price) VALUES 
('Laptop', 'High performance laptop for study', 799.99),
('Textbook', 'Cloud Computing Basics', 45.50),
('USB Drive', '32GB USB Flash Drive', 12.00);
