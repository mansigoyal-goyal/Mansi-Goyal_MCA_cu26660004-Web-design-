# Practical 6: Retrieve records and format an HTML response string.
from html import escape
from db_helper import get_connection
conn = get_connection(); cur = conn.cursor(dictionary=True)
cur.execute("SELECT user_id,name,email,city FROM users")
rows = cur.fetchall()
body = "".join(f"<tr><td>{r['user_id']}</td><td>{escape(r['name'])}</td><td>{escape(r['email'])}</td><td>{escape(r['city'] or '')}</td></tr>" for r in rows)
html = "<html><body><h1>Users</h1><table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>City</th></tr>" + body + "</table></body></html>"
print(html)
cur.close(); conn.close()
