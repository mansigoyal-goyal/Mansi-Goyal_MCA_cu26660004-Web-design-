CREATE DATABASE IF NOT EXISTS online_bookstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE online_bookstore;
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL,email VARCHAR(150) UNIQUE NOT NULL,password VARCHAR(255) NOT NULL,role ENUM('customer','admin') DEFAULT 'customer',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE books(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(200) NOT NULL,author VARCHAR(150) NOT NULL,category VARCHAR(80) NOT NULL,description TEXT,price DECIMAL(10,2) NOT NULL,stock INT NOT NULL DEFAULT 0,image VARCHAR(255),featured TINYINT DEFAULT 0);
CREATE TABLE orders(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL,total DECIMAL(10,2) NOT NULL,shipping_name VARCHAR(100),shipping_address TEXT,shipping_city VARCHAR(100),shipping_postal VARCHAR(20),status ENUM('Pending','Shipped','Delivered') DEFAULT 'Pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id));
CREATE TABLE order_items(id INT AUTO_INCREMENT PRIMARY KEY,order_id INT NOT NULL,book_id INT NOT NULL,title VARCHAR(200),price DECIMAL(10,2),quantity INT,FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,FOREIGN KEY(book_id) REFERENCES books(id));
CREATE TABLE reviews(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL,book_id INT NOT NULL,rating TINYINT NOT NULL,comment TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,UNIQUE KEY(user_id,book_id),FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,FOREIGN KEY(book_id) REFERENCES books(id) ON DELETE CASCADE);
CREATE TABLE wishlist(user_id INT NOT NULL,book_id INT NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(user_id,book_id),FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,FOREIGN KEY(book_id) REFERENCES books(id) ON DELETE CASCADE);
INSERT INTO books(title,author,category,description,price,stock,featured) VALUES
('The Silent Patient','Alex Michaelides','Fiction','A psychological thriller.',399,12,1),
('Atomic Habits','James Clear','Self Help','Small habits, remarkable results.',499,20,1),
('Clean Code','Robert C. Martin','Technology','A guide to clean software craftsmanship.',650,8,1),
('The Psychology of Money','Morgan Housel','Business','Lessons on wealth and behaviour.',350,15,0),
('Ikigai','Héctor García','Self Help','Finding purpose and balance.',299,10,0);
