import mysql.connector
from config import DB_CONFIG
def get_connection(include_database=True):
    cfg = DB_CONFIG.copy()
    if not include_database: cfg.pop("database", None)
    return mysql.connector.connect(**cfg)
