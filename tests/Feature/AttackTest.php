<?php

namespace Tests\Feature;

use App\Battle;
use App\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttackTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function strong_own_character_wins_while_attacking_basic_opponent(): void
    {
        // Given we have a signed in user that already has a strongCharacter
        $user = factory(User::class)->create();
        $this->actingAs($user);
        /** @var Character $strongOwnCharacter */
        $strongOwnCharacter = factory(Character::class)->create([
            'user_id' => $user,
            'hit_points' => 1000,
            'strength' => 1000,
            'agility' => 1000,
            'constitution' => 1000,
            'intelligence' => 1000,
            'charisma' => 1000,
        ]);
        $basicOpponentCharacter = factory(Character::class)->create([
            'location_id' => $strongOwnCharacter->location_id
        ]);

        // When we hit home folder
        $response = $this->post("/character/{$basicOpponentCharacter->id}/attack");

        $battle = Battle::query()->firstOrFail();

        // We are redirected to the Battle page
        $response->assertRedirect(route('battle.show', $battle->id));
        $this->assertEquals($strongOwnCharacter->id, $battle->attacker_id);
        $this->assertEquals($strongOwnCharacter->id, $battle->victor_id);
        $this->assertEquals($basicOpponentCharacter->id, $battle->defender_id);
    }

    /**
     * @test
     */
    public function basic_own_character_looses_while_attacking_strong_opponent(): void
    {
        // Given we have a signed in user that already has a strongCharacter
        $user = factory(User::class)->create();
        $this->actingAs($user);
        /** @var Character $basicOwnCharacter */
        $basicOwnCharacter = factory(Character::class)->create([
            'user_id' => $user,
        ]);
        $strongOpponentCharacter = factory(Character::class)->create([
            'location_id' => $basicOwnCharacter->location_id,
            'hit_points' => 1000,
            'strength' => 1000,
            'agility' => 1000,
            'constitution' => 1000,
            'intelligence' => 1000,
            'charisma' => 1000,
        ]);

        // When we hit home folder
        $response = $this->post("/character/{$strongOpponentCharacter->id}/attack");

        $battle = Battle::query()->firstOrFail();

        // We are redirected to the Battle page
        $response->assertRedirect(route('battle.show', $battle->id));
        $this->assertEquals($basicOwnCharacter->id, $battle->attacker_id);
        $this->assertEquals($strongOpponentCharacter->id, $battle->victor_id);
        $this->assertEquals($strongOpponentCharacter->id, $battle->defender_id);
    }
}
