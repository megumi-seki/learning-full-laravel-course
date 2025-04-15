<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerifyController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route("home")
            ->with("success","Your Email was verified. You can now add cars!");
    }

    public function notice()
    {
        return view("auth.verify-email");
    }

    public function send(Request $request) 
    {
        /** @var User $user ????*/
        $user = $request->user();
        $request->user()->sendEmailVerificationNotification();

        return back()->with("success","Verification link sent");
    }
}
