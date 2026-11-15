# PHP E-commerce System

Laravel 12 project using PHP, server-rendered HTML (Blade), CSS, and lightweight JavaScript. The responsive storefront uses an iOS-inspired glassmorphism aesthetic and adapts to phones, tablets, and desktop displays.

## Run locally
Requires PHP 8.2+, Composer 2, and MySQL 8+.

```bash
composer install
cp .env.example .env
php artisan key:generate
# Create the configured database and set DB_* values in .env
php artisan migrate --seed
php artisan serve
```

Assessment features: customer sign-up/login; product browsing/search; protected cart and checkout; automatic totals calculated server-side in integer cents; transactional stock updates; role-protected admin product management; order history; wishlist; and a payment-method demo (cash on delivery or manual bank transfer). Product and order schema references are in `database/schema.sql` and migrations.

Admin accounts must be promoted privately by a trusted operator after registration, e.g. `UPDATE users SET is_admin = TRUE WHERE email = 'admin@example.com';`. Public registration never grants admin rights.

Payment selection is demonstrative only: no money is collected. Add a payment gateway, webhook verification, email verification, shipping/tax rules, automated tests, HTTPS, and production security review before launch.
