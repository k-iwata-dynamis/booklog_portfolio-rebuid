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
        Schema::create('book_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('genre')->nullable();
            $table->integer('price')->nullable();
            $table->decimal('review_average')->nullable();
            $table->unsignedInteger('review_count')->nullable();
            $table->string('image_url')->nullable();
            $table->string('book_url')->nullable();
            $table->string('rakuten_book_id')->nullable();
            $table->enum('type',['to_read','to_buy']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_marks');
    }
};
