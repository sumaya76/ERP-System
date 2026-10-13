<?php

namespace App\Console\Commands;

use App\Services\ErpReminderService;
use Illuminate\Console\Command;

class GenerateErpReminders extends Command
{
    protected $signature = 'erp:generate-reminders';

    protected $description = 'Generate in-app alerts for project deadlines, approvals, stock and documents';

    public function handle(ErpReminderService $reminders): int
    {
        $count = $reminders->generate();
        $this->info("Generated or refreshed {$count} active ERP reminder(s).");

        return self::SUCCESS;
    }
}
