-- Create the database
CREATE DATABASE IF NOT EXISTS FD;
USE FD;

-- Create a table for menu items
CREATE TABLE menu_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  img VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create a table for cart (for orders)
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  menu_item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL
);
INSERT INTO admin (username,password) VALUES ('ahmad7', SHA2('admin123',256));
