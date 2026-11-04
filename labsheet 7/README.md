# BookNest Online Bookstore – 21 Practicals
## Setup
1. Extract ZIP and copy folder to `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Import `sql/bookstore.sql` using `http://localhost/phpmyadmin`.
4. Check MySQL credentials in `includes/config.php` (default XAMPP root / blank password).
5. Open `http://localhost/PHP_Online_Bookstore_21_Practicals/`.
6. Register an account. To grant admin access, run `UPDATE users SET role='admin' WHERE email='your-email@example.com';` in phpMyAdmin, then log in again.
## Practicals
1 homepage `index.php`; 2 schema `sql/bookstore.sql`; 3 dynamic book grid `index.php`; 4 GET book detail `book.php`; 5 hashed registration/login `auth/`; 6 session cart `cart/`; 7 checkout `checkout.php`; 8 admin inventory `admin/books.php`; 9 order status `admin/orders.php`; 10 search/filter homepage; 11 pagination homepage; 12 order history `orders/history.php`; 13 stock validation cart/checkout; 14 prepared SQL statements throughout; 15 reviews `review.php` and `book.php`; 16 invoice `orders/invoice.php`; 17 wishlist `wishlist.php`; 18 JS validation `assets/validation.js`; 19 shared responsive CSS `assets/style.css`; 20 end-to-end app journey; 21 sales reports `admin/reports.php`.
## Notes
Educational local project only. Checkout records orders but does not process real payments. For public deployment add CSRF protection, HTTPS, secure cookies, rate limiting, robust admin controls and payment gateway integration.
