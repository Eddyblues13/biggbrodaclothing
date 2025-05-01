<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('brand')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->string('image')->nullable();
            $table->string('image_public_id')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_new')->default(true);
            $table->enum('status', ['draft', 'active', 'inactive'])->default('active');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['category_id', 'status']);
            $table->index(['price', 'status']);
            $table->index(['is_featured', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
