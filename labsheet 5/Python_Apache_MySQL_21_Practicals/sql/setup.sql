CREATE DATABASE IF NOT EXISTS python_web_db;
USE python_web_db;
CREATE TABLE IF NOT EXISTS users (
 user_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 city VARCHAR(100),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS activity_log (
 log_id INT AUTO_INCREMENT PRIMARY KEY,
 event_type VARCHAR(50) NOT NULL,
 details TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS sessions (
 session_id VARCHAR(128) PRIMARY KEY,
 user_id INT NOT NULL,
 expires_at DATETIME NOT NULL,
 FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
INSERT IGNORE INTO users (user_id,name,email,city) VALUES
(1,'Aarav Sharma','aarav@example.com','Roorkee'),
(2,'Diya Verma','diya@example.com','Meerut'),
(3,'Kabir Singh','kabir@example.com','Noida');
