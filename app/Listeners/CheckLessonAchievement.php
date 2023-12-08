<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AchievementUnlocked;
use DB;

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
        /**
         * Assuming that the watched lessons are stored in the db.
         *
         * get all lesson users had watched and count
         */

        $lesson = $event->lesson;
        $user = $event->user;

        //Attach user to the lesson first

        $user->lessons()->attach($lesson,["watched"=>true]);

        $watched_lessons = DB::table("lesson_user")->where("lesson_id", $lesson->id)->where("user_id", $user->id)->where("watched",true)->count();


        //get achievement no_required_of_activity
        $achievement = Achievement::where("type","lessons")->where("no_required_of_activity",$watched_lessons)->first();

        //send an event with the achievement name if no of users watched lessons matches any achievemnent no_required_of_activity
        if($achievement){
            event(new AchievementUnlocked($achievement->name,$user->id));
        }
    }
}
