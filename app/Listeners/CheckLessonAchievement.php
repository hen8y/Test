<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckLessonAchievement
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched $event): void
    {
        //get all users watched and count

        //get achievement no_required_of_activity

        //send an event with the achievement name if no of users watched lessons matches any achievemnent no_required_of_activity
    }
}
