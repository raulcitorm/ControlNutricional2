<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->foreignId('dish_id')->constrained()->onDelete('cascade');
            $table->decimal('servings', 3, 1)->default(1);
            $table->timestamps();
            
            $table->unique(['user_id', 'date', 'meal_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};