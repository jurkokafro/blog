<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\returnSelf;

class RegisterController extends Controller
{
    //
    public function create() {
        return view('register.create');
    }

    public function store() {


        $attributes = request()->validate([
            'name' => ['required','max:255'],
            'username' => ['required','max:255','min:3', Rule::unique('users', 'username')],
            'email' => ['required','email','max:255', Rule::unique('users', 'email')],
            'password' => ['required','min:7'],
        ]);

        //$attributes['password'] = bcrypt($attributes['password']); --> zdaj za to poskrbi User.php funcija set
        //setPasswordAttribute ... - avtomatsko poskrbi laravel za to

        $user = User::create($attributes);

        //Login user
        auth()->login($user);

        //session()->flash("success", "Your account has been created!");

        return redirect('/')->with("success", "Your account has been created!");
    }
}
