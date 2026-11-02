# Practical 8: Update profile by user ID.
from db_helper import get_connection
uid = int(input("User ID: "))
name = input("New name: ").strip()
city = input("New city: ").strip()
conn = get_connection(); cur = conn.cursor()
cur.execute("UPDATE users SET name=%s, city=%s WHERE user_id=%s", (name,city,uid))
conn.commit()
print("Updated." if cur.rowcount else "User not found.")
cur.close(); conn.close()
