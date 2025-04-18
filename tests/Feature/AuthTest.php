<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_returns_success_on_login_page(): void
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->get(route("login"));

        // $response->assertOk();
        // $response->assertCreated();
        // $response->assertBadRequest();
        $response->assertStatus(200)
            ->assertSee("Login")
            ->assertSee("Forgot Password?")
            ->assertSee("Click here to create one")
            ->assertSee("Google")
            ->assertSee("Facebook")
            ->assertSee('<a href="'.route('password.request').'"', false)
            ->assertSee('<a href="'.route('signup').'"', false)
            ->assertSee('<a href="'.route('login.oauth', 'google').'"', false)
            ->assertSee('<a href="'.route('login.oauth', 'facebook').'"', false);

        // // Shorter Syntax of Writing Tests
        // $this->get(route("login"))
        //     ->assertStatus(200)
        //     ->assertSee("Login");
    }

    public function test_should_not_be_possible_to_login_with_incorrect_credentials()
    {   /**
         * @var TestResponse $response
         */
        User::factory()->create([
            "email" => "jane@example.com2",
            "password" => bcrypt("password")
        ]);
        $response = $this->post(route("login.store"), [
            "emial" => "jane@example.com2",
            "password" => "123456"
        ]); 
        
        $response->assertStatus(302)
            // ->assertSessionHasErrors(["email"]);
            ->assertInvalid(["email"]);
    }

    public function test_should_be_possible_to_login_with_correct_credentials()
    {   /**
         * @var TestResponse $response
         */
        User::factory()->create([
            "email" => "jane@example.com2",
            "password" => bcrypt("password")
        ]);
        $response = $this->post(route("login.store"), [
            "email" => "jane@example.com2",
            "password" => "password"
        ]);
        
        $response->assertStatus(302)
            ->assertRedirectToRoute(("home"))
            ->assertSessionHas(["success"]);
    }

    public function test_returns_success_on_signup_page(): void
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->get(route("signup"));

        $response->assertStatus(200)
            ->assertSee("Signup")
            ->assertSee("Google")
            ->assertSee("Facebook")
            ->assertSee("Click here to login")
            ->assertSee('<a href="'.route('login.oauth', 'google').'"', false)
            ->assertSee('<a href="'.route('login.oauth', 'facebook').'"', false)
            ->assertSee('<a href="'.route('login').'"', false);
    }

    public function test_should_not_possible_to_signup_with_empty_data()
    {
        /** @var TestResponse $response */
        $response = $this->post(route("signup.store"), [
            "name" => "",
            "email" => "",
            "phone" => "",
            "password" => "",
            "password_confirmation" => ""
        ]);

        $response->assertStatus(302)
            ->assertInvalid(["name", "email", "phone", "password"]);
    }

    public function test_should_not_possible_to_signup_with_incorrect_password()
    {
        /** @var TestResponse $response */
        $response = $this->post(route("signup.store"), [
            "name" => "jane",
            "email" => "jane@example.com",
            "phone" => "123",
            "password" => "password",
            "password_confirmation" => "password2"
        ]);

        $response->assertStatus(302)
            ->assertInvalid(["password"]);
    }

    public function test_should_not_possible_to_signup_with_exisiting_email()
    {
        /** @var TestResponse $response */

        User::factory()->create([
            "email" => "jane@example.com"
        ]);

        $response = $this->post(route("signup.store"), [
            "name" => "jane",
            "email" => "jane@example.com",
            "phone" => "123",
            "password" => "passworD1231!",
            "password_confirmation" => "passworD1231!"
        ]);

        $response->assertStatus(302)
            ->assertInvalid(["email"]);
    }

    public function test_should_possible_to_signup_with_correct_data()
    {
        /** @var TestResponse $response */
        $response = $this->post(route("signup.store"), [
            "name" => "jane doe",
            "email" => "jane@example.com",
            "phone" => "123456789",
            "password" => "Password1234!",
            "password_confirmation" => "Password1234!"
        ]);

        $response->assertStatus(302)
            ->assertRedirectToRoute("home")
            ->assertSessionHas(["success"]);
    }

    public function test_returns_success_on_forgot_password_page(): void
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->get(route("password.request"));

        $response->assertStatus(200)
            ->assertSee("Request password reset")
            ->assertSee("Click here to login")
            ->assertSee('<a href="'. route('login') .'"', false);
    }

    public function test_should_not_request_password_reset_with_incorrect_email()
    {
        /** @var TestResponse $response */

        $response = $this->post(route("password.email"), [
            "email" => "jane@example.com"
        ]);

        $response->assertStatus(302)
            ->assertInvalid(["email"]);
    }

    public function test_should_request_password_reset_with_correct_email()
    {
        /** @var TestResponse $response */
        User::factory()->create([
            "email" => "jane@example.com"
        ]);

        $response = $this->post(route("password.email"), [
            "email" => "jane@example.com"
        ]);

        $response->assertStatus(302)
            ->assertRedirectToRoute(("home"))
            ->assertSessionHas(["success"]);
    }

    public function test_should_display_Signup_andLogin_links_for_guest_user() 
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->get(route("home"));

        $response->assertStatus(200)
            ->assertSeeInOrder([
                '<a href="'.route("car.create").'" class="btn btn-add-new-car">',
                "Signup"
            ], false)
            ->assertSeeInOrder([
                '<a href="'.route("login").'" class="btn btn-login flex items-center">',
                "Login"
            ], false)
            ->assertDontSee('Welcome, ');
            
    }

    public function test_should_display_Welcome_dropdown_for_authenticated_user() 
    {
        $this->seed();
        $user = User::first();        

        $response = $this->actingAs($user)
            ->get(route("home"));

        $response->assertStatus(200)
            ->assertDontSee(("Signup"))
            ->assertDontSee(("Login"))
            ->assertSee('Welcome, '.$user->name)
            ->assertSee('<a href="javascript:void(0)" class="navbar-menu-handler">', false);
    }

    public function test_should_test_the_user_cannott_access_other_users_car()
    {
        $this->seed();
        [$user1, $user2] = User::limit(2)->get();

        dump($user1, $user2);

        $car = $user1->cars()->first();

        /** @var TestResponse $response */
        $response = $this->actingAs($user2)
            ->get(route("car.edit", $car));

        $response->assertStatus(404);
        
    }
}
