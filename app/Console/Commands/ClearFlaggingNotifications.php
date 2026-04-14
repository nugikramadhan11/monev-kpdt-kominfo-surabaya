<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;

class ClearFlaggingNotifications extends Command
{
    protected $signature = 'notifications:clear-flagging';
    protected $description = 'Clear all flagging notifications';

    public function handle()
    {
        $count = Notification::where('type', 'FLAGGING')->delete();
        $this->info("Dihapus {$count} notifikasi flagging");
    }
}
