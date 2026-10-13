<?php

namespace App\Livewire\Shared;

use App\Models\ErpNotification;
use App\Services\ErpReminderService;
use Livewire\Component;

class Notifications extends Component
{
    public function generateReminders(ErpReminderService $reminders): void
    {
        abort_unless(in_array(auth()->user()?->role?->name, ['admin', 'hr'], true), 403);
        $count = $reminders->generate();
        session()->flash('success', "Reminder scan completed; {$count} active alerts found.");
    }

    public function markRead(int $notificationId): void
    {
        ErpNotification::where('user_id', auth()->id())
            ->whereKey($notificationId)
            ->whereNull('resolved_at')
            ->update(['read_at' => now()]);
    }

    public function markAllRead(): void
    {
        ErpNotification::where('user_id', auth()->id())
            ->whereNull('resolved_at')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function render()
    {
        $role = auth()->user()?->role?->name;
        abort_unless(in_array($role, ['admin', 'hr'], true), 403);

        return view('livewire.shared.notifications', [
            'notifications' => ErpNotification::where('user_id', auth()->id())
                ->whereNull('resolved_at')->latest()->paginate(30),
            'unreadCount' => ErpNotification::where('user_id', auth()->id())
                ->whereNull('resolved_at')->whereNull('read_at')->count(),
        ])->layout($role === 'admin' ? 'layouts.admindashboard' : 'layouts.hrmanagerdashboard');
    }
}
