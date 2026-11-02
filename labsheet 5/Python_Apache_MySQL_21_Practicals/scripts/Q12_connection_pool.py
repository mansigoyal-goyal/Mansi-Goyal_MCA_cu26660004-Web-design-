# Practical 12: Use a connection pool for repeated database work.
from mysql.connector.pooling import MySQLConnectionPool
from config import DB_CONFIG
pool = MySQLConnectionPool(pool_name="python_web_pool", pool_size=5, **DB_CONFIG)
conn = pool.get_connection(); cur = conn.cursor()
cur.execute("SELECT COUNT(*) FROM users")
print("User count:", cur.fetchone()[0])
cur.close(); conn.close()  # close() returns it to the pool
