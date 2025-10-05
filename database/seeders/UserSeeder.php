<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        User::create([
            'username' => 'Admin User',
            'phone' => '+201000000001',
            'whatsapp' => '+201000000001',
            'password' => Hash::make('0123456789'),
            'user_type' => 'advertiser',
            'otp_verified' => 0,
            'role' => 'admin',
        ]);

        // Normal user account
        User::create([
            'username' => 'Normal User',
            'phone' => '+201000000002',
            'whatsapp'=>'+201000000002',
            'password' => Hash::make('0123456789'),
            'user_type' => 'advertiser',
            'otp_verified' => 0,
            'role' => 'user',
        ]);
    }
}
