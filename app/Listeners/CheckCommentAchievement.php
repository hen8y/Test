<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckCommentAchievement
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
    public function handle(CommentWritten $event): void
    {
        //get all comments and count
        $comment = $event->comment;
        $comment_count = $comment->user->comments()->count();

        //get achievement no_required_of_activity

        $achievement = Achievement::where("type","comment")->where("no_required_of_activity",$comment_count)->first();

        //send an event with the achievement name if no of users comment matches any achievemnent no_required_of_activity
        if($achievement){
            event(new AchievementUnlocked($achievement,$comment->user));
        }
    }
}
