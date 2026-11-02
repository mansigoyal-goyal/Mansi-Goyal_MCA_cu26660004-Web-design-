# Practical 4: Create database python_web_db and table users.
from db_helper import get_connection
conn = get_connection(False)
cur = conn.cursor()
cur.execute("CREATE DATABASE IF NOT EXISTS python_web_db")
cur.execute("USE python_web_db")
cur.execute("""CREATE TABLE IF NOT EXISTS users (
 user_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 city VARCHAR(100),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)""")
conn.commit()
print("Database and users table created.")
cur.close(); conn.close()
