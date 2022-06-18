<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('user.profiles.index');
    }
    
    public function updateProfile(ProfileRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $user->update($request->validated());
        return back()
            ->with('success','Updated profile successfully');
    }

    public function password()
    {
        return view('user.profiles.password');
    }

    public function changePassword(PasswordRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $user->update(['password' => $request->new_password]);

        Auth::logout();
 
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect()->route('login.index');
    }
}