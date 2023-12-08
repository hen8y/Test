<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;

use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardAchievement
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


        //get the achievement name and user id
        $achievement_name = $event->achievement_name;
        $user = $event->user;
        $achievement = Achievement::where('name',$achievement_name)->get();

        //get the id and attach user to this achievement
        $user->achievements()->attach($achievement);

        //count all user's achievement
        $achievement_count = $user->achievements()->count();


        //get badges no_required_of_achievement and compare
        $badge = Badge::where("no_required_of_achievement",$achievement_count)->first();

        //send an event with the badge name if no of achievement matches any badge no_required_of_achievement
        if($badge){
            event(new BadgeUnlocked($badge, $user));
        }


    }
}
