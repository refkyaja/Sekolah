<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBell extends Component
{
    public bool $isOpen = false;
    public int $unreadCount = 0;
    public array $notifications = [];

    public function mount(): void
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) return;

        $items = Notification::forAuthUser($user)
            ->recent(15)
            ->get();

        $this->notifications = $items->map(fn($n) => [
            'id'        => $n->id,
            'type'      => $n->type,
            'title'     => $n->title,
            'body'      => $n->body,
            'data'      => $n->data,
            'is_unread' => $n->isUnread(),
            'time_ago'  => $n->created_at->diffForHumans(),
        ])->toArray();

        $this->unreadCount = $items->filter(fn($n) => $n->isUnread())->count();
    }

    public function toggleDropdown(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeDropdown(): void
    {
        $this->isOpen = false;
    }

    public function markRead(string $id): void
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) return;

        $notification = Notification::forAuthUser($user)->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        $this->loadNotifications();
    }

    public function markAllRead(): void
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) return;

        Notification::forAuthUser($user)->unread()->update(['read_at' => now()]);
        $this->loadNotifications();
    }

    #[On('notification-received')]
    public function onNotificationReceived(): void
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
