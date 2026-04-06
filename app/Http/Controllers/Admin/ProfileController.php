<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user   = Auth::user();
        $tokens = $user->tokens()->latest()->get();
        return view('admin.profile.edit', compact('user', 'tokens'));
    }

    public function tokenCreate(Request $request)
    {
        $request->validate(['token_name' => 'required|string|max:100']);

        $token = Auth::user()->createToken($request->input('token_name'));

        return back()
            ->with('new_token', $token->plainTextToken)
            ->with('success', 'Token créé — copiez-le maintenant, il ne sera plus affiché.');
    }

    public function tokenRevoke(Request $request, int $tokenId)
    {
        Auth::user()->tokens()->where('id', $tokenId)->delete();

        return back()->with('success', 'Token révoqué.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ];

        if ($request->filled('password')) {
            $rules['password']              = ['required', 'confirmed', Password::min(8)];
            $rules['password_confirmation'] = 'required';
        }

        $validated = $request->validate($rules);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour.');
    }
}
