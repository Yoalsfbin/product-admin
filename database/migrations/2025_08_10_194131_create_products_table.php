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
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku_code')->unique();
            $table->unsignedInteger('price');

            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('main_photo_id')->nullable()->constrained('product_photos')->nullOnDelete();

            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamp('published_at')->nullable();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete(); 

            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'status']);
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
