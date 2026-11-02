# Practical 19: Validate inputs and use parameterized SQL writes.
import re
from html import escape
from db_helper import get_connection
name = input("Name: ").strip()
email = input("Email: ").strip()
city = input("City: ").strip()
if not 1 <= len(name) <= 100: raise ValueError("Name must be 1-100 characters.")
if len(email) > 150 or not re.fullmatch(r"[^@\s]+@[^@\s]+\.[^@\s]+", email):
    raise ValueError("Enter a valid email.")
if len(city) > 100: raise ValueError("City must be at most 100 characters.")
conn = get_connection(); cur = conn.cursor()
cur.execute("INSERT INTO users(name,email,city) VALUES(%s,%s,%s)", (name,email,city))
conn.commit()
print("Saved:", escape(name))
cur.close(); conn.close()
