<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ClearAllFlagging extends Command
{
    protected $signature = 'flagging:clear-all';
    protected $description = 'Clear flagging status for all ASN users';

    public function handle()
    {
        // Reset flagging untuk semua ASN
        $updated = User::role('ASN')->update([
            'is_flagged' => false,
            'flagged_at' => null,
        ]);

        $this->info("✓ Flagging status cleared for {$updated} ASN users");
        $this->info('Dashboard is now clean! Ready for demo 🚀');
    }
}
