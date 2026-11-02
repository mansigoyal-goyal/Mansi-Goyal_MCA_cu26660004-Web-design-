# Practical 3: Connect and retrieve MySQL server version.
from db_helper import get_connection
conn = None
try:
    conn = get_connection(False)
    cur = conn.cursor()
    cur.execute("SELECT VERSION()")
    print("MySQL Server Version:", cur.fetchone()[0])
    cur.close()
except Exception as err:
    print("Connection/query error:", err)
finally:
    if conn and conn.is_connected(): conn.close()
