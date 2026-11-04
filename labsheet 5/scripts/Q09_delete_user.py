# Practical 9: Delete a row and handle errors.
from db_helper import get_connection
conn = None
try:
    uid = int(input("User ID to delete: "))
    if input("Type YES to confirm: ") == "YES":
        conn = get_connection(); cur = conn.cursor()
        cur.execute("DELETE FROM users WHERE user_id=%s", (uid,))
        conn.commit(); print("Deleted." if cur.rowcount else "No matching user.")
        cur.close()
    else: print("Cancelled.")
except ValueError:
    print("Enter a valid numeric ID.")
except Exception as err:
    print("Database error:", err)
finally:
    if conn and conn.is_connected(): conn.close()
