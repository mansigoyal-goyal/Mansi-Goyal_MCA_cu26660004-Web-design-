# PHP + MySQL Web App (Lab Sheet 9)

## Setup (VS Code)
1. Install **XAMPP** (or WAMP/Laragon) – start **Apache** and **MySQL**.
2. Copy this folder into `C:\xampp\htdocs\webapp` (or `/opt/lampp/htdocs/webapp`).
3. Open **http://localhost/phpmyadmin** → *Import* → choose `database.sql` → Go.
4. Edit `config/db.php` if your MySQL user/password differ.
5. Open the folder in VS Code and visit **http://localhost/webapp/** 
   (Optional without XAMPP Apache: `php -S localhost:8000` inside the folder; needs PHP with mysqli + fileinfo enabled.)
6. Register a user, log in, and explore.

## Task → File map
| # | Task | File(s) |
|---|------|---------|
| 1 | Database & tables | database.sql |
| 2 | DB connection + require_once | config/db.php |
| 3 | Registration + password_hash | register.php |
| 4 | Login + password_verify + session | login.php |
| 5 | Protected dashboard | dashboard.php, includes/functions.php |
| 6 | Secure logout | logout.php |
| 7 | Insert with prepared statements | product_add.php |
| 8 | Product table (SELECT) | products.php |
| 9 | Edit/UPDATE | product_edit.php |
| 10 | Delete + JS confirm | product_delete.php, assets/app.js |
| 11 | Pagination | products.php |
| 12 | Search/filter (LIKE, BETWEEN) | products.php |
| 13 | Column sorting | products.php |
| 14 | Image upload | includes/functions.php, product_add.php |
| 15 | SQL injection demo | sql_injection_demo.php |
| 16 | XSS protection | e() helper used everywhere |
| 17 | Remember Me cookie | login.php |
| 18 | Shopping cart | cart.php |
| 19 | Checkout transaction | checkout.php |
| 20 | AJAX live search | suggest.php, assets/app.js |
