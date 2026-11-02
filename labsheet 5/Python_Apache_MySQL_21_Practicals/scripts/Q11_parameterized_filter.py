# Practical 11: Parameterized query to prevent SQL injection.
from db_helper import get_connection
city = input("Filter by city: ").strip()
conn = get_connection(); cur = conn.cursor(dictionary=True)
cur.execute("SELECT user_id,name,email,city FROM users WHERE city=%s", (city,))
for row in cur.fetchall(): print(row)
cur.close(); conn.close()
