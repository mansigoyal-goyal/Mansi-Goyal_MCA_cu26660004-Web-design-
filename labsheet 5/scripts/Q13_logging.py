# Practical 13: Log access timestamps and database errors.
import logging
from pathlib import Path
from db_helper import get_connection
log = Path(__file__).resolve().parents[1] / "logs" / "server.log"
logging.basicConfig(filename=log, level=logging.INFO, format="%(asctime)s %(levelname)s %(message)s")
logging.info("Script accessed")
conn = None
try:
    conn = get_connection(); cur = conn.cursor()
    cur.execute("SELECT COUNT(*) FROM users")
    logging.info("Query succeeded; count=%s", cur.fetchone()[0])
    cur.close()
except Exception:
    logging.exception("Database operation failed")
finally:
    if conn and conn.is_connected(): conn.close()
print("Log written to", log)
