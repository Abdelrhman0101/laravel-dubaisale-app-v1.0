<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            // 'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role'=>'admin',
            'user_type'=>'advertiser',
            'is_active'=>true,
            'phone'=>'+971501234567',
            'whatsapp'=>'+971501234567',
            // storing your provided hash directly:
            'password' => Hash::make('A97AC00A712327FE986B299BEC5E300C'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
