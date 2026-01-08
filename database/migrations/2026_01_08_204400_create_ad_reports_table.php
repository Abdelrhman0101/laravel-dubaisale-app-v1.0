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
        Schema::create('ad_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ad_type'); // car_sale, car_rent, restaurant, job, real_estate, electronic, other_service, car_service
            $table->unsignedBigInteger('ad_id');
            $table->string('reason'); // inappropriate, spam, misleading, duplicate, other
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // ملاحظة الأدمن
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null'); // الأدمن الذي راجع البلاغ
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // Index for better performance
            $table->index(['ad_type', 'ad_id']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_reports');
    }
};
