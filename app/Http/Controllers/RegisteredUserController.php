<?php

namespace App\Http\Controllers;

use App\Mail\RegisteredUserMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)]
        ]);

        $employerAttributes = $request->validate([
            'employer' => ['required'],
            'logo' => ['required', File::types(['png', 'jpg', 'webp'])]
        ]);

        $user = User::create($userAttributes);


        // upload the logo for the employer before creating
        // will save it inside ( storage->app->public )
        $logoPath = $request->logo->store('logos');

        // will set user_id by default inside the employer field because it has been defined already inside the user
        $user->employer()->create([
            'name' => $employerAttributes['employer'],
            'logo' => $logoPath
        ]);


        event(new Registered($user));


        Auth::login($user);

        return redirect('/');
    }

    // verify email notice handler
    public function verifyNotice()
    {
        return view('auth.verify-email');
    }

    // Email verification handler
    // This request is build in laravel we don't need to do anything here
    public function verifyEmail(EmailVerificationRequest $request)
    {

        $request->fulfill();

        return redirect('/');
    }


    public function verifyHandler(Request $request)
    {

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
