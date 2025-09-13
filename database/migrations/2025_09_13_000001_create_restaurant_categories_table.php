<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('restaurant_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed some default English categories so it's not empty
        $now = now();
        DB::table('restaurant_categories')->insert([
            ['name' => 'Fast Food', 'active' => true, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fine Dining', 'active' => true, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cafe', 'active' => true, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Desserts', 'active' => true, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Seafood', 'active' => true, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Steakhouse', 'active' => true, 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Vegetarian', 'active' => true, 'sort_order' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pizza', 'active' => true, 'sort_order' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Burgers', 'active' => true, 'sort_order' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Middle Eastern', 'active' => true, 'sort_order' => 10, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_categories');
    }
};