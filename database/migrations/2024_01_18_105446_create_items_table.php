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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable(false)->index();
            $table->string('title')->nullable(false);
            $table->string('author')->nullable(false);
            $table->year('year')->nullable(false);
            $table->tinyInteger('state')->nullable(false);
            $table->string('about_state');
            $table->float('price')->nullable(false);
            $table->json('image');
            $table->string('note');
            $table->boolean('isActive')->default(1);
            $table->boolean('isDeleted')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
