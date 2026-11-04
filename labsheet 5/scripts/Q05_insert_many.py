# Practical 5: Insert multiple records with executemany().
from db_helper import get_connection
records = [("Riya","riya@example.com","Roorkee"),
           ("Arjun","arjun@example.com","Haridwar"),
           ("Meera","meera@example.com","Dehradun")]
conn = get_connection(); cur = conn.cursor()
cur.executemany("INSERT IGNORE INTO users(name,email,city) VALUES(%s,%s,%s)", records)
conn.commit()
print(cur.rowcount, "record(s) inserted.")
cur.close(); conn.close()
