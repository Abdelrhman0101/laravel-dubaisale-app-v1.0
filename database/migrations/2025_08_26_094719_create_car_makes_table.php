<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_makes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            // We don't need timestamps for this simple table
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_makes');
    }
};