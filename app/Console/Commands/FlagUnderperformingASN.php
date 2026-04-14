<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Posting;
use App\Models\Evaluation;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * FlagUnderperformingASN Command - Auto-flag ASN yang underperforming
 * 
 * Command ini menjalankan proses auto-flagging untuk ASN yang tidak mencapai target 4 posting per bulan.
 * 
 * Proses yang dilakukan:
 * 1. Hitung posting verified setiap ASN untuk bulan berjalan
 * 2. Jika posting < 4: flag ASN dan buat notification FLAGGING
 * 3. Jika posting >= 4: unflag ASN (clear flagging dari bulan sebelumnya)
 * 4. Buat/update evaluation record untuk tracking history
 * 
 * Command dapat dipanggil melalui:
 * - Manual: php artisan posting:flag-underperforming
 * - Scheduler: Scheduled di Kernel.php untuk menjalankan setiap hari
 * - Button di Pimpinan Dashboard
 */
class FlagUnderperformingASN extends Command
{
    protected $signature = 'posting:flag-underperforming';
    protected $description = 'Auto-flag ASN yang tidak post 4x bulan ini. Jalankan manual atau via scheduler';

    /**
     * Execute command untuk auto-flag underperforming ASN
     * 
     * Proses:
     * 1. Loop semua ASN users
     * 2. Hitung posting verified bulan berjalan untuk setiap ASN
     * 3. Set flagging status (true jika < 4, false jika >= 4)
     * 4. Buat FLAGGING notification jika user baru di-flag
     * 5. Create/update evaluation record
     * 6. Log status setiap user
     */
    public function handle()
    {
        $currentMonth = now()->format('Y-m');
        $year = now()->year;
        $month = now()->month;
        
        // Get all ASN users
        $asnUsers = User::role('ASN')->get();

        foreach ($asnUsers as $user) {
            // Count postings for current month
            $postingCount = Posting::where('user_id', $user->id)
                ->whereYear('posted_date', $year)
                ->whereMonth('posted_date', $month)
                ->count();

            $user->posting_count_this_month = $postingCount;

            // Auto-flag if less than 4 postings
            if ($postingCount < 4) {
                $user->is_flagged = true;
                $user->flagged_at = now();
                
                // Create notification for flagging
                $this->createFlaggingNotification($user, $postingCount);
            } else {
                $user->is_flagged = false;
                $user->flagged_at = null;
            }

            $user->save();

            // Create evaluation record if not exists
            $evaluation = Evaluation::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'evaluation_month' => now()->startOfMonth(),
                ],
                [
                    'posting_count' => $postingCount,
                    'status' => 'PENDING',
                ]
            );

            $this->info("ASN {$user->name}: {$postingCount} postings - " . ($user->is_flagged ? 'FLAGGED' : 'OK'));
        }

        $this->info('Auto-flagging completed');
    }

    /**
     * Buat notifikasi FLAGGING untuk user yang under-performing
     * 
     * Proses:
     * 1. Delete previous flagging notifications untuk menghindari duplicate
     * 2. Buat notification baru dengan pesan yang menginformasikan posting count
     * 3. Set action_url ke dashboard agar user bisa langsung akses
     * 
     * @param \App\Models\User $user
     * @param int $postingCount
     * @return void
     */
    private function createFlaggingNotification(User $user, int $postingCount)
    {
        // Delete previous flagging notifications to avoid duplicates
        $user->notifications()->where('type', 'FLAGGING')->delete();

        // Create new notification
        Notification::create([
            'user_id' => $user->id,
            'type' => 'FLAGGING',
            'title' => '🚩 Status Flagged - Target Belum Tercapai',
            'message' => "Anda baru mencapai {$postingCount} posting dari target 4 posting untuk bulan ini. Tingkatkan jumlah posting Anda untuk menghilangkan status flagged.",
            'icon' => '🚩',
            'color' => 'red',
            'action_url' => route('asn.dashboard'),
        ]);
    }
}

