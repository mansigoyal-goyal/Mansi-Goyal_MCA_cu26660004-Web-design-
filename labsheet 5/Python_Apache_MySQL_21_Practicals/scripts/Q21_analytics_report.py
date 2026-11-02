# Practical 21: Counts and averages for an admin dashboard.
from db_helper import get_connection
conn = get_connection(); cur = conn.cursor(dictionary=True)
cur.execute("SELECT COUNT(*) AS total_users, COUNT(DISTINCT city) AS total_cities, AVG(user_id) AS average_id FROM users")
summary = cur.fetchone()
cur.execute("SELECT city, COUNT(*) AS user_count FROM users GROUP BY city ORDER BY user_count DESC")
print("ADMIN ANALYTICS")
print("Total users:", summary["total_users"])
print("Distinct cities:", summary["total_cities"])
print("Average user ID:", round(summary["average_id"] or 0, 2))
print("Users by city:")
for row in cur.fetchall(): print(row["city"] or "Not specified", ":", row["user_count"])
cur.close(); conn.close()
