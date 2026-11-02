# Practical 16: Flask JSON API endpoint reading MySQL records.
from flask import Flask, jsonify
from db_helper import get_connection
app = Flask(__name__)
@app.get("/api/users")
def users():
    conn = get_connection()
    try:
        cur = conn.cursor(dictionary=True)
        cur.execute("SELECT user_id,name,email,city FROM users ORDER BY user_id")
        rows = cur.fetchall(); cur.close()
        return jsonify(rows)
    finally: conn.close()
if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5000, debug=False)
