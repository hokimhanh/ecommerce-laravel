<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended('/admin/dashboard');
        } else {
            return view('auth.register');
        }

    }
    public function store(RegisterRequest $request)
    {
        $input = $request->validated();

        $checkEmail = User::whereEmail($input['email'])->first();
        if($checkEmail) {
            return back()->withErrors([
                'status' => 'The email has already been taken.',
            ])->withInput();
        }
        $user = User::create($input);
        
        auth()->login($user);
        
        return redirect('/admin/dashboard');
    }
}
