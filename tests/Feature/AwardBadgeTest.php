<?php

namespace Tests\Feature;

use App\Events\BadgeUnlocked;
use App\Listeners\AwardBadge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Facades\Event;

class AwardBadgeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_award_badge()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create(['name' => "Intermediate"]);

        Event::fake();

        $listener = new AwardBadge();
        $event = new BadgeUnlocked($badge, $user);
        $listener->handle($event);


        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id,
        ]);

        $this->assertEquals($badge->name, $user->fresh()->current_badge);

    }
}
