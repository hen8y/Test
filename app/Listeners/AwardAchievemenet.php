<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardAchievemenet
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
    public function handle(AchievementUnlocked $event): void
    {


        //get the achievement name


        //compare with a name in database


        //get the id and attach user to this achievement


        //get all users achievement and count


        //get badges no_required_of_achievement


        //send an event with the badge name if no of achievement matches any badge no_required_of_achievement

    }
}
