<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Posting;
use App\Models\PostingEngagement;
use Illuminate\Database\Seeder;

class PostingSeeder extends Seeder
{
    public function run(): void
    {
        // Commented out - ASN should upload postings manually
        return;
        
        $asnUsers = User::role('ASN')->get();
        $pilars = \App\Models\Pilar::all();
        // Platform format: Instagram, TikTok, YouTube, Facebook (matching platform-icon component)
        $platforms = ['Instagram', 'TikTok', 'YouTube'];

        foreach ($asnUsers as $asn) {
            // Create 2-3 sample postings for each ASN user
            $postingCount = rand(2, 3);
            
            for ($i = 0; $i < $postingCount; $i++) {
                $platform = $platforms[array_rand($platforms)];
                $platformLower = strtolower(str_replace('TikTok', 'tiktok', str_replace('YouTube', 'youtube', str_replace('Instagram', 'instagram', str_replace('Facebook', 'facebook', $platform)))));
                
                // Generate realistic sample URLs based on platform
                if ($platformLower === 'instagram') {
                    $url = 'https://instagram.com/p/' . strtoupper(bin2hex(random_bytes(8)));
                } elseif ($platformLower === 'tiktok') {
                    $url = 'https://tiktok.com/@' . strtolower($asn->name) . '/video/' . rand(1000000000000000, 9999999999999999);
                } else {
                    $url = 'https://youtube.com/watch?v=' . bin2hex(random_bytes(6));
                }

                $posting = Posting::create([
                    'user_id' => $asn->id,
                    'pilar_id' => $pilars->random()->id,
                    'wilayah_id' => $asn->wilayah_id,
                    'url' => $url,
                    'platform' => $platform,
                    'caption' => 'Sample posting dari ' . $asn->name,
                    'posted_date' => now()->subDays(rand(0, 15))->toDateString(),
                    'status' => 'VERIFIED',
                    'verified_by' => $asn->id,
                    'verified_at' => now(),
                ]);

                // Create engagement record with sample data
                PostingEngagement::create([
                    'posting_id' => $posting->id,
                    'likes' => rand(10, 500),
                    'comments' => rand(1, 50),
                    'shares' => rand(0, 20),
                ]);
            }
        }

        echo "\nCreated sample postings for each ASN user successfully\n";
    }
}
