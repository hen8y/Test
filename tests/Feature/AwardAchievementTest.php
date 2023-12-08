<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Support\Facades\Event;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Listeners\AwardAchievement;

class AwardAchievementTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_award_achievement_listener()
    {

        $user = User::factory()->create();
        $achievement = Achievement::factory()->create();
        Badge::factory()->create(['no_required_of_achievement' => 1]);

        Event::fake();

        $event = new AchievementUnlocked($achievement, $user);
        $listener = new AwardAchievement();
        $listener->handle($event);


        $this->assertDatabaseHas('achievement_user', [
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
        ]);


        Event::assertDispatched(BadgeUnlocked::class);
    }
}
