<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Notification $notification,
        public readonly array $targetUserIds
    ) {}

    /**
     * Broadcast ke private channel tiap user yang ditarget.
     * Setiap user hanya subscribe ke channel-nya sendiri.
     */
    public function broadcastOn(): array
    {
        return array_map(
            fn(int $userId) => new PrivateChannel("notifications.{$userId}"),
            $this->targetUserIds
        );
    }

    public function broadcastAs(): string
    {
        return 'notification.new';
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->notification->id,
            'type'       => $this->notification->type,
            'title'      => $this->notification->title,
            'body'       => $this->notification->body,
            'data'       => $this->notification->data,
            'created_at' => $this->notification->created_at->toIso8601String(),
        ];
    }
}
