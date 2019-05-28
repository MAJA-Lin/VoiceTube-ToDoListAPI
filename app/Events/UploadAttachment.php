<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\ToDoList;

class UploadAttachment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $todo;
    public $content;
    public $name;
    public $description;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ToDoList $todo, string $content, string $name, string $description)
    {
        $this->todo = $todo;
        $this->description = $description;
        $this->content = $content;
        $this->name = $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
