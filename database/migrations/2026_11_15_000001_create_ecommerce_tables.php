<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 140)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('price_cents');
            $table->unsignedInteger('stock')->default(0);
            $table->string('image_url', 2048)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['is_active', 'category_id']);
        });

        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number', 24)->unique();
            $table->string('customer_name', 160);
            $table->string('email', 190)->index();
            $table->string('phone', 40)->nullable();
            $table->string('address', 255);
            $table->string('city', 120);
            $table->string('postal_code', 30);
            $table->string('country', 100);
            $table->unsignedBigInteger('subtotal_cents');
            $table->unsignedBigInteger('shipping_cents')->default(0);
            $table->unsignedBigInteger('total_cents');
            $table->string('status', 30)->default('pending')->index();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name', 180);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price_cents');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
