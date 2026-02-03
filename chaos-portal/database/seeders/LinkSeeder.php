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
        // 既存データが残ると確率が崩れるので、毎回入れ替える
        DB::table('links')->truncate();

        $links = [];
        
        // 1. アタリのサイト
        $safeSites = [
            // 6割の確率でここに飛ぶ（要件）
            ['title' => 'Luqman Hadi', 'url' => 'https://www.luqmanhadi.com/'],
            ['title' => 'Google', 'url' => 'https://google.com'],
            ['title' => 'Yahoo!', 'url' => 'https://yahoo.co.jp'],
            ['title' => 'X (Twitter)', 'url' => 'https://twitter.com'],
            ['title' => 'YouTube', 'url' => 'https://youtube.com'],
            ['title' => '虚構新聞', 'url' => 'https://kyoko-np.net/'],
            ['title' => '阿部寛のHP', 'url' => 'http://abehiroshi.la.coocan.jp/'],
        ];

        // 2. 50個になるまで埋める
        for ($i = 0; $i < 50; $i++) {
            // 配分:
            // - 30%: トラップ（強制ログアウト）
            // - 60%: https://www.luqmanhadi.com/
            // - 10%: その他の安全サイト
            $roll = rand(1, 100);

            if ($roll <= 30) {
                $links[] = [
                    'title' => '未実装機能 ' . ($i + 1),
                    'url' => null,
                    'is_trap' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } elseif ($roll <= 90) {
                $site = $safeSites[0]; // Luqman Hadi
                $links[] = [
                    'title' => $site['title'] . ' (Ver.' . $i . ')',
                    'url' => $site['url'],
                    'is_trap' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                // index 1..n から選ぶ（Luqman以外）
                $site = $safeSites[rand(1, count($safeSites) - 1)];
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