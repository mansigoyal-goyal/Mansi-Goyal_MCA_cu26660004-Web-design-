CREATE DATABASE IF NOT EXISTS college_db
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE college_db;

CREATE TABLE IF NOT EXISTS students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    enrollment_date DATE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS activity_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    activity VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_activity_student FOREIGN KEY (student_id)
      REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Create a restricted application user. Replace the password before use.
CREATE USER IF NOT EXISTS 'college_app'@'localhost'
IDENTIFIED BY 'ChangeThisPassword!';
GRANT SELECT, INSERT, UPDATE ON college_db.* TO 'college_app'@'localhost';
FLUSH PRIVILEGES;
