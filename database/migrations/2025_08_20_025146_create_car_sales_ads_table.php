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
    Schema::create('car_sales_ads', function (Blueprint $table) {
        // == Basic Ad Info ==
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // الربط بجدول المستخدمين
        $table->string('add_category')->default('Cars Sales');
        $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Pending');
        $table->boolean('admin_approved')->default(false);
        $table->unsignedBigInteger('views')->default(0);
        $table->integer('rank')->default(0);
        $table->timestamps();

        // == Plan Info ==
        $table->string('plan_type')->nullable();
        $table->integer('plan_days')->nullable();
        $table->timestamp('plan_expires_at')->nullable();
        
        // == Car Data ==
        $table->string('title');
        $table->text('description');
        $table->string('make'); // e.g., Toyota
        $table->string('model'); // e.g., Camry
        $table->string('trim')->nullable(); // e.g., GLX
        $table->year('year');
        $table->unsignedInteger('km'); // Kilometers
        $table->decimal('price', 10, 2); // e.g., 150000.00
        $table->string('specs')->nullable(); // e.g., GCC, American
        $table->string('car_type')->nullable(); // e.g., Sedan, SUV
        $table->string('trans_type'); // e.g., Automatic, Manual
        $table->string('fuel_type')->nullable(); // e.g., Petrol, Diesel, Electric
        $table->string('color')->nullable();
        $table->string('interior_color')->nullable();
        $table->boolean('warranty')->default(false);
        $table->integer('engine_capacity')->nullable(); // in CC
        $table->integer('cylinders')->nullable();
        $table->integer('horsepower')->nullable();
        $table->integer('doors_no')->nullable();
        $table->integer('seats_no')->nullable();
        $table->string('steering_side')->nullable(); // e.g., Left, Right
        
        // == Advertiser Info (pre-filled but can be overridden) ==
        $table->string('advertiser_name');
        $table->string('phone_number');
        $table->string('whatsapp')->nullable();
        $table->string('emirate');
        $table->string('area')->nullable();
        $table->string('advertiser_type')->nullable();
        
        // == Media & Location ==
        $table->string('main_image'); // سيتم تخزين المسار فقط
        $table->json('thumbnail_images')->nullable(); // سيتم تخزين مصفوفة من المسارات
        $table->string('location')->nullable(); // Google Maps link or coordinates

        // == Active Offers Box ==
        $table->boolean('active_offers_box_status')->default(false);
        $table->integer('active_offers_box_days')->nullable();
        $table->timestamp('active_offers_box_expires_at')->nullable();
        $table->integer('active_offers_box_rank')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_sales_ads');
    }
};
