<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $pages = [
            [
                'title' => 'Terms & Conditions',
                'type' => 'terms',
                'content' => 'By using Dubai Sale, you agree to our terms and conditions. All ads must be legal, accurate, and respect the community guidelines.',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Privacy Policy',
                'type' => 'policy',
                'content' => 'We respect your privacy. Dubai Sale collects only the necessary information to provide better services and does not share personal data with third parties.',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // [
            //     'title' => 'Refund Policy',
            //     'type' => 'refund',
            //     'content' => 'Refunds are only applicable for paid promotions and must be requested within 7 days of purchase. Free ads are non-refundable.',
            //     'is_active' => true,
            //     'created_at' => $now,
            //     'updated_at' => $now,
            // ],
            [
                'title' => 'About Dubai Sale',
                'type' => 'about',
                'content' => 'Dubai Sale is the leading classifieds platform in the UAE for cars, real estate, electronics, and more. Our mission is to connect buyers and sellers seamlessly.',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Frequently Asked Questions',
                'type' => 'faq',
                'content' => 'Q: How do I post an ad? 
                              A: Simply register, choose a category, and upload your details. 
                              Q: How long does my ad stay online? 
                              A: Free ads are visible for 30 days, promoted ads for longer.',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}




