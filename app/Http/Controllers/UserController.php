<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $current_user = Auth::user();

        if ($user->id == $current_user->id) {
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|unique:users,email, '.$user->id,
                'old_password' => 'required_with:password|old_password',
                'password' => 'confirmed|min:6|nullable'
            ]);

            if (!is_null($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->update($request->all());

            return back()->with('success', trans('auth.infos_edited'));
        }
        return back()->with('error',trans('auth.wrong_user'));
    }
}
