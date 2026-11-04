# Practical 18: Store a session record in MySQL (educational demonstration).
import secrets
from datetime import datetime, timedelta
from db_helper import get_connection
uid = int(input("Existing user ID: "))
token = secrets.token_urlsafe(32)
expiry = datetime.now() + timedelta(hours=1)
conn = get_connection(); cur = conn.cursor()
cur.execute("INSERT INTO sessions(session_id,user_id,expires_at) VALUES(%s,%s,%s)", (token,uid,expiry))
conn.commit()
print("Session created. Keep this token private:", token)
cur.close(); conn.close()
# Real applications also need secure cookies, HTTPS, expiry validation and CSRF protection.
