<?php

namespace App\Listeners;

use App\Events\UploadAttachment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Attachment;

class ProcessUploadingAttachment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UploadAttachment  $event
     * @return void
     */
    public function handle(UploadAttachment $event)
    {
        // TODO: Upload file by content
        // Now just mock the path
        $path = substr(str_shuffle(MD5(microtime())), 0, 25);

        $attachment = new Attachment();
        $attachment->path = $path;
        $attachment->name = $event->name;
        $attachment->description = $event->description;

        $event->todo->attachments()->save($attachment);

        return $attachment;
    }
}
