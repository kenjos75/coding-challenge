<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $message;
    



    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        $this->message = 'message';
        Log::info('NotificationSent event constructed');
    }


    public function broadcastWith()
    {
        return ['message' => $this->message];
    }

    public function broadcastOn()
    {
        $channel = 'notifications.' . $this->notification->user_id;
        Log::info('Broadcasting NotificationSent on channel', ['channel' => $channel]);
        return new Channel($channel);
    }

    public function broadcastAs()
    {
        return 'notification.sent';
    }
}
