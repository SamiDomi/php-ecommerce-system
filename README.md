# PHP E-commerce System

A Laravel 12 starter storefront with product browsing/search, category filtering, a session cart, guest checkout, transactional stock checks, order confirmation, and a MySQL schema.

## Requirements

- PHP 8.2+ with PDO MySQL, Mbstring, OpenSSL, Tokenizer, XML, Ctype, JSON, and BCMath extensions
- Composer 2
- MySQL 8+

## Run locally

```bash
composer install
cp .env.example .env
php artisan key:generate
# Create the configured MySQL database, then set DB_* values in .env
php artisan migrate --seed
php artisan serve
```

Open http://127.0.0.1:8000. `database/schema.sql` is provided as a standalone MySQL reference; normally use the Laravel migration with `php artisan migrate`.

## Included

- Responsive product catalog, search, and category filter
- Product detail pages and stock-aware session cart
- Guest checkout with address validation and order creation
- Transactional inventory decrement and order-item snapshots
- Demo categories and products from the database seeder

## Before production

This is a working starter, not a production-ready turnkey store. Payment processing, tax/shipping calculation, customer authentication, order-management/admin UI, email delivery, image uploads, rate limiting, and automated tests still need to be configured and reviewed. Checkout currently creates **pending** orders and does not charge a payment method. Configure HTTPS, secure production environment values (`APP_DEBUG=false`), backups, monitoring, and payment-provider webhooks before launch.
