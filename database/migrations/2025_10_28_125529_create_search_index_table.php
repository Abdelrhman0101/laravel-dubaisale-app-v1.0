<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('search_index', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->string('item_type')->index(); 
            $table->unsignedBigInteger('item_id')->index(); 
            $table->string('category_slug')->nullable();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('main_image')->nullable();
            $table->timestamps();

    
            $table->fullText(['title', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_index');
    }
};
