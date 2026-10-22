<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->string('role')->default('customer')->index();
            $t->boolean('is_active')->default(true);
            $t->string('phone')->nullable();
            $t->string('address')->nullable();
            $t->string('city')->nullable();
            $t->string('postal_code')->nullable();
            $t->rememberToken();
            $t->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $t) {
            $t->string('email')->primary();
            $t->string('token');
            $t->timestamp('created_at')->nullable();
        });
        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->boolean('is_active')->default(true);
            $t->integer('sort_order')->default(0);
            $t->timestamps();
        });
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained()->restrictOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('sku')->unique();
            $t->text('description')->nullable();
            $t->decimal('price', 12, 2);
            $t->decimal('compare_at_price', 12, 2)->nullable();
            $t->unsignedInteger('stock')->default(0);
            $t->unsignedInteger('low_stock_threshold')->default(5);
            $t->string('image')->nullable();
            $t->string('material')->nullable();
            $t->string('dimensions')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->boolean('is_featured')->default(false)->index();
            $t->timestamps();
        });
        Schema::create('coupons', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->string('type');
            $t->decimal('value', 12, 2);
            $t->decimal('min_order', 12, 2)->default(0);
            $t->unsignedInteger('usage_limit')->nullable();
            $t->unsignedInteger('used_count')->default(0);
            $t->timestamp('expires_at')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('order_number')->unique();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $t->string('status')->default('pending')->index();
            $t->string('payment_method');
            $t->string('payment_status')->default('unpaid');
            $t->decimal('subtotal', 12, 2);
            $t->decimal('discount', 12, 2)->default(0);
            $t->decimal('shipping', 12, 2)->default(0);
            $t->decimal('tax', 12, 2)->default(0);
            $t->decimal('total', 12, 2);
            $t->string('name');
            $t->string('email');
            $t->string('phone');
            $t->string('address');
            $t->string('city');
            $t->string('postal_code')->nullable();
            $t->text('notes')->nullable();
            $t->timestamp('shipped_at')->nullable();
            $t->timestamp('delivered_at')->nullable();
            $t->timestamps();
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $t->string('product_name');
            $t->string('sku');
            $t->decimal('unit_price', 12, 2);
            $t->unsignedInteger('quantity');
            $t->decimal('line_total', 12, 2);
            $t->timestamps();
        });
        Schema::create('inventory_movements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $t->integer('change');
            $t->unsignedInteger('stock_after');
            $t->string('reason');
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('reviews', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->unsignedTinyInteger('rating');
            $t->text('comment');
            $t->boolean('is_approved')->default(false);
            $t->timestamps();
            $t->unique(['product_id', 'user_id']);
        });
        Schema::create('newsletter_subscribers', function (Blueprint $t) {
            $t->id();
            $t->string('email')->unique();
            $t->timestamps();
        });
        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('subject');
            $t->text('message');
            $t->boolean('is_read')->default(false);
            $t->timestamps();
        });
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['settings', 'contact_messages', 'newsletter_subscribers', 'reviews', 'inventory_movements', 'order_items', 'orders', 'coupons', 'products', 'categories', 'password_reset_tokens', 'users'] as $name) {
            Schema::dropIfExists($name);
        }
    }
};
