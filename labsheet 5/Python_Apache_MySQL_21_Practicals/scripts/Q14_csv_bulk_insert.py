# Practical 14: Read CSV and bulk insert records.
import csv
from pathlib import Path
from db_helper import get_connection
path = Path(__file__).resolve().parents[1] / "sample_users.csv"
with path.open(newline="", encoding="utf-8") as f:
    data = [(r["name"],r["email"],r["city"]) for r in csv.DictReader(f)]
conn = get_connection(); cur = conn.cursor()
cur.executemany("INSERT IGNORE INTO users(name,email,city) VALUES(%s,%s,%s)", data)
conn.commit(); print(cur.rowcount, "row(s) inserted.")
cur.close(); conn.close()
