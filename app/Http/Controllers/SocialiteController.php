<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallBack($provider) 
    {
        try {
            $field = null;
            if ($provider === "google") {
                $field = "google_id";
            } elseif($provider === "facebook") {
                $field = "facebook_id";
            }

            $user = Socialite::driver($provider)->stateless()->user();
            $dbUser = User::where("email", $user->email)->first();

            if ($dbUser) {
                $dbUser->$field = $user->id;
                $dbUser->save();
            } else {
                $dbUser = User::create([
                "name" => $user->name,
                "email" => $user->email,
                $field => $user->id,
                "email_verified_at" => now()
                ]);
            }

            Auth::login($dbUser);
            return redirect()->intended(route("home"));

        } catch (\Exception $e) {
            return redirect(route("login"))
                ->with("error", $e->getMessage() ?: "Something went wrong");
        }
    }
}
