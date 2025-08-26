<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_years', function (Blueprint $table) {
            $table->id();
            $table->year('year')->unique(); // نوع البيانات year هو الأفضل للسنة
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_years');
    }
};