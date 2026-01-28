<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [];
        
        // 1. アタリのサイト
        $safeSites = [
            ['title' => 'Google', 'url' => 'https://google.com'],
            ['title' => 'Yahoo!', 'url' => 'https://yahoo.co.jp'],
            ['title' => 'X (Twitter)', 'url' => 'https://twitter.com'],
            ['title' => 'YouTube', 'url' => 'https://youtube.com'],
            ['title' => '虚構新聞', 'url' => 'https://kyoko-np.net/'],
            ['title' => '阿部寛のHP', 'url' => 'http://abehiroshi.la.coocan.jp/'],
        ];

        // 2. 50個になるまで埋める
        for ($i = 0; $i < 50; $i++) {
            // 30%の確率で「トラップ（未実装）」
            if (rand(1, 100) <= 30) {
                $links[] = [
                    'title' => '未実装機能 ' . ($i + 1),
                    'url' => null,
                    'is_trap' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                $site = $safeSites[array_rand($safeSites)];
                $links[] = [
                    'title' => $site['title'] . ' (Ver.' . $i . ')',
                    'url' => $site['url'],
                    'is_trap' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('links')->insert($links);
    }
}