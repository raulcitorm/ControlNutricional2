<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_global')->default(false);
            
            
            $table->decimal('calories', 8, 2)->default(0); 
            $table->decimal('total_fat', 8, 2)->default(0);
            $table->decimal('saturated_fat', 8, 2)->default(0); 
            $table->decimal('trans_fat', 8, 2)->default(0); 
            $table->decimal('polyunsaturated_fat', 8, 2)->default(0); 
            $table->decimal('monounsaturated_fat', 8, 2)->default(0); 
            $table->decimal('carbohydrates', 8, 2)->default(0);
            $table->decimal('sugars', 8, 2)->default(0);
            $table->decimal('fiber', 8, 2)->default(0); 
            $table->decimal('protein', 8, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};