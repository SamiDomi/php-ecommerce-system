-- MySQL 8+ reference schema. The Laravel migration in database/migrations is the source of truth.
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(180) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    description TEXT NULL,
    price_cents INT UNSIGNED NOT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    image_url VARCHAR(2048) NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX products_active_category_index (is_active, category_id),
    CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(24) NOT NULL UNIQUE,
    customer_name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(40) NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(120) NOT NULL,
    postal_code VARCHAR(30) NOT NULL,
    country VARCHAR(100) NOT NULL,
    subtotal_cents BIGINT UNSIGNED NOT NULL,
    shipping_cents BIGINT UNSIGNED NOT NULL DEFAULT 0,
    total_cents BIGINT UNSIGNED NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX orders_email_index (email),
    INDEX orders_status_index (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NULL,
    product_name VARCHAR(180) NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    unit_price_cents INT UNSIGNED NOT NULL,
    CONSTRAINT order_items_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT order_items_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    INDEX order_items_product_id_index (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
