<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('search_index', function (Blueprint $table) {
            // Only set InnoDB engine for MySQL
            $driver = DB::connection()->getDriverName();
            if ($driver === 'mysql') {
                $table->engine = 'InnoDB'; 
            }
            
            $table->string('item_type')->index(); 
            $table->unsignedBigInteger('item_id')->index(); 
            $table->string('category_slug')->nullable();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('main_image')->nullable();
            $table->timestamps();
        });

        // Only add fulltext index for MySQL (SQLite doesn't support it)
        if (DB::connection()->getDriverName() === 'mysql') {
            Schema::table('search_index', function (Blueprint $table) {
                $table->fullText(['title', 'content']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_index');
    }
};
