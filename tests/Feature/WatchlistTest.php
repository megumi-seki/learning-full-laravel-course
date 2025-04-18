<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class WatchlistTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_not_be_able_to_access_to_favorite_page_as_guest_user(): void
    {
        /** @var TestResponse $response */

        $response = $this->get(route("watchlist.index"));
        $response->assertRedirectToRoute("login");
        $response->assertStatus(302);
    }

    public function test_should_be_able_to_access_to_favorite_page_as_authenticated_user(): void
    {
        /** @var TestResponse $response */

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route("watchlist.index"));

        $response->assertOk()
            ->assertSee("My Favourite Cars"||"You don't have any favorite cars.");
    }
}
