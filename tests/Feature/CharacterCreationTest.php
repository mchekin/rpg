<?php

namespace Tests\Feature;

use App\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CharacterCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authenticated_user_without_character_record_is_redirected_to_character_create_page()
    {
        // Given we have a signed in user that does not have character yet
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When we hit home folder
        $response = $this->get('/home');

        // We are redirected to the Character creation page
        $response->assertRedirect(route('character.create'));
    }

    /**
     * @test
     */
    public function an_authenticated_user_with_character_record_is_redirected_to_character_location_page()
    {
        // Given we have a signed in user that already has a character
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $character = factory(Character::class)->create(['user_id' => $user]);

        // When we hit home folder
        $response = $this->get('/home');

        // We are redirected to the Character creation page
        $response->assertRedirect(route('location.show', $character->location));
    }
}
