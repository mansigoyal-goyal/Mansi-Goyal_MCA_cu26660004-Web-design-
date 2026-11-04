# Practical 17: Back up schema and data using the mysqldump utility.
import subprocess
from pathlib import Path
from config import DB_CONFIG
folder = Path(__file__).resolve().parents[1] / "backups"
folder.mkdir(exist_ok=True)
target = folder / "python_web_db_backup.sql"
cmd = ["mysqldump","-h",DB_CONFIG["host"],"-P",str(DB_CONFIG["port"]),
       "-u",DB_CONFIG["user"],f"-p{DB_CONFIG['password']}",DB_CONFIG["database"]]
with target.open("w", encoding="utf-8") as out:
    subprocess.run(cmd, stdout=out, check=True)
print("Backup saved:", target)
