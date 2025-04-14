<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password as PasswordFacades;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password;



class PasswordResetController extends Controller
{
    public function showForgotPassword()
    {
        return view("auth.forgot-password");
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(["email" =>["required","email"]]);

        $status = PasswordFacades::sendResetLink($request->only("email"));

        // return back()->with("success", "Password reset email was sent.");
        if ($status === PasswordFacades::RESET_LINK_SENT) {
            return back()->with("success", __($status));
        }

        return back()->withErrors(["email" => __($status)])
            ->withInput($request->only("email"));
    }

    public function showResetPassword() 
    {
        return view("auth.reset-password");

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            "token" => ["required"],
            "email" => ["required", "email"],
            "password" => ["required", "string", "confirmed",
                    Password::min(8)
                  ->max(24)
                  ->numbers()
                  ->mixedCase()
                  ->symbols()
                  ->uncompromised()]
                ]);

        $status = PasswordFacades::reset(
            $request->only(["email", "password", "password_confirmation", "token"]),
            function (User $user, string $password) {
                        $user->forceFill([
                        "password" => Hash::make($password)
                        ])->setRememberToken(Str::random(60));

                        $user->save();

                        event(new PasswordReset($user));
                    });

        if ($status === PasswordFacades::PASSWORD_RESET) {
            return redirect()->route("login")->with("success", __($status));
        }

        return back()->withErrors(["email" => __($status)]);
    }
}
