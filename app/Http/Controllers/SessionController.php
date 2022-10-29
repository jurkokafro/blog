<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create() {
        return view('sessions.create');
    }
    public function destroy() {
        auth()->logout();

        return redirect('/')->with("success","Goodbye");
    }

    public function store() {

        $attributes = request()->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'We are really sorry, but your provided credentials could not be verified!'
            ]);
        }

        session()->regenerate(); //zaščita pred session fixation

        return redirect('/')->with('success', 'Welcome back');

    }
}
