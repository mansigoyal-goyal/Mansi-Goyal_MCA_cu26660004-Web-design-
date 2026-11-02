# Python + Apache + MySQL – 21 Practicals

## Requirements
Python 3.10+, Apache (XAMPP or Linux Apache), MySQL, VS Code (optional).

## Setup
1. Extract this ZIP and open the folder in VS Code.
2. In the terminal, create a virtual environment:
   - Windows: `py -m venv .venv` then `.venv\Scripts\activate`
   - Linux/macOS: `python3 -m venv .venv` then `source .venv/bin/activate`
3. Install libraries: `python -m pip install -r requirements.txt`
4. Edit `config.py` with your MySQL credentials.
5. Import `sql/setup.sql` in MySQL Workbench or phpMyAdmin.

## Run normal scripts
From the project root, run (example): `python scripts/Q03_server_version.py`.
Each practical has its own file in `scripts/`, except CGI practical 7 in `cgi-bin/`.

## Apache CGI (Practicals 1, 7, 10)
See `apache/httpd-cgi.conf.example` and `apache/htaccess.example`. Enable `mod_cgi`/`mod_cgid`, configure `ExecCGI` and `AddHandler cgi-script .py`, then restart Apache. Update the Python shebang to the correct interpreter path. Apache CGI setup differs by OS/build; do not overwrite existing Apache configuration blindly.
Python's `cgi` module was deprecated in 3.11 and removed from the standard library in 3.13. Practical 7 is a syllabus example and is easiest with Python 3.11 or a compatible `legacy-cgi` package. For modern development use Flask (Practical 16).

## Flask JSON endpoint (Practical 16)
Run `python scripts/Q16_json_endpoint.py`; visit `http://127.0.0.1:5000/api/users`. This is a development server. An illustrative `mod_wsgi` configuration is in `apache/wsgi_flask.conf.example`; install a mod_wsgi build compatible with your Apache/Python versions before deploying.

## Notes
- Practical 17 uses `mysqldump`; ensure it is installed and on PATH.
- Keep secrets, logs, and backups outside public web directories in real deployments.
- Never allow uploaded files to execute as scripts.
- These are local educational examples, not production-ready public services.
