# PHP, Apache and MySQL — 21 Separate Practicals

## Project layout
- `Q01.php` through `Q21.php`: each practical has its own separate PHP file.
- `Q02-phpinfo.php`: diagnostic `phpinfo()` page for Question 2.
- `includes/config.php`: shared MySQL connection settings.
- `includes/db.php`: shared secure PDO connection.
- `includes/header.php` and `includes/footer.php`: shared page layout.
- `assets/style.css`: one common external stylesheet.
- `sql/setup.sql`: database and table setup, plus restricted app-user example.
- `apache/httpd-vhosts.conf.example`: virtual-host configuration sample.
- `uploads/`: destination for uploaded images.

## Run using XAMPP on Windows
1. Install XAMPP with Apache, PHP and MySQL/MariaDB.
2. Copy this entire project folder into `C:\xampp\htdocs\`.
3. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
4. Open `http://localhost/PHP_Apache_MySQL_21_Practicals/`.
5. Run `sql/setup.sql` in phpMyAdmin or MySQL Workbench.
6. Edit `includes/config.php` and enter the database username and password you created.
7. Open `Q01.php` to `Q21.php` separately from the home page.

For the restricted account in `setup.sql`, the sample credentials are `college_app` / `ChangeThisPassword!`. Change this password before using the project. If you use a different MySQL account, update `includes/config.php` to match. The restricted user has SELECT, INSERT and UPDATE privileges only; table creation should be performed by an administrator.

## Important setup notes
- **Q1:** To test the exact URL `http://localhost`, put an `index.php` or `index.html` in Apache's document root (`htdocs`). The included project home page loads at `http://localhost/PHP_Apache_MySQL_21_Practicals/`.
- **Q2:** Edit the active `php.ini`, set `display_errors = On` and `error_reporting = E_ALL`, then restart Apache. Visit `Q02-phpinfo.php` to inspect the loaded configuration. Delete or restrict the phpinfo page after testing.
- **Q3:** Database creation SQL is also in `sql/setup.sql`.
- **Q10:** Adjust the sample paths in `apache/httpd-vhosts.conf.example`, enable the vhosts include in Apache configuration, add `127.0.0.1 collegeweb.local` to the system hosts file, and restart Apache.
- **Q13:** PHP must allow file uploads. The upload folder must be writable by the web server. Only image extensions and matching MIME types are accepted; the maximum size is 2 MB.
- **Q14:** The app account is intentionally restricted. For tasks that create tables or alter schema, use a database administrator.
- **Q17:** Open `Q17.php` to download `students.csv`.
- **Q18:** Typical XAMPP logs are in `C:\xampp\apache\logs\access.log` and `error.log`; paths vary by installation.
- **Q19:** The SQL setup creates the activity log table required by the transaction example.
- **Q20:** Enable missing extensions in the active `php.ini`, then restart Apache.

## Security reminders
This is a local learning project. Do not expose it publicly as-is. Use HTTPS, environment-based secrets, CSRF protection, rate limiting, hardened upload storage, and production-safe error handling before deployment. Do not leave `display_errors` enabled on a public server. The contact/authentication examples are educational and should be extended before production use.
