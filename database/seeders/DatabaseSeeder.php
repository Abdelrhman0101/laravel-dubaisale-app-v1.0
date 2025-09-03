<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'phone' => '+971501234567',
            'is_active' => true,
        ]);

        // Seed car sales ad specifications
        $this->call(CarSalesAdSpecSeeder::class);
        
        // Seed car service types
        $this->call(CarServiceTypeSeeder::class);
    }
}
