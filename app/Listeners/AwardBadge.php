<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardBadge
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
    public function handle(BadgeUnlocked $event): void
    {
        $badge_name = $event->badge_name;
        $user = $event->user;
        $badge = Badge::where("name",$badge_name)->get();


        $user->badges()->attach($badge);
        $user->update(["current_badge"=>$badge_name]);

    }
}
