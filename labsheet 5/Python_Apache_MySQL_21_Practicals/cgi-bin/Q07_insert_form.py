#!/usr/bin/env python3
# Practical 7: CGI form handler. Python cgi is legacy (see README).
import cgi, html, sys
from pathlib import Path
sys.path.insert(0, str(Path(__file__).resolve().parents[1]))
from db_helper import get_connection
print("Content-Type: text/html; charset=utf-8")
print()
form = cgi.FieldStorage()
name = form.getfirst("name","").strip()
email = form.getfirst("email","").strip()
city = form.getfirst("city","").strip()
if not name or not email:
    print("<h2>Name and email are required.</h2>")
else:
    conn = None
    try:
        conn = get_connection(); cur = conn.cursor()
        cur.execute("INSERT INTO users(name,email,city) VALUES(%s,%s,%s)", (name,email,city))
        conn.commit(); print("<h2>User saved.</h2>"); cur.close()
    except Exception:
        print("<h2>Could not save record. Check server log.</h2>")
    finally:
        if conn and conn.is_connected(): conn.close()
print("<p>Name: " + html.escape(name) + "</p>")
