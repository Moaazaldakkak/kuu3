<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->insert([
            [
                'name' => 'John Doe',
                'image' => 'https://example.com/images/john.jpg',
                'description' => 'A software developer with a love for open-source technologies.',
                'social_media_accounts' => json_encode([
                    ['platform' => 'Twitter', 'link' => 'https://twitter.com/johndoe'],
                    ['platform' => 'LinkedIn', 'link' => 'https://linkedin.com/in/johndoe'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'image' => 'https://example.com/images/jane.jpg',
                'description' => 'A creative designer and content strategist.',
                'social_media_accounts' => json_encode([
                    ['platform' => 'Instagram', 'link' => 'https://instagram.com/janesmith'],
                    ['platform' => 'Behance', 'link' => 'https://behance.net/janesmith'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
