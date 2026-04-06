<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isMember()) {
            return redirect()->route('member.profile.edit');
        }
        return view('member.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->isPending()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Votre compte est en attente d\'activation.'])->onlyInput('email');
            }

            return redirect()->intended(route('member.profile.edit'));
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('member.profile.edit');
        }

        $enabled = Setting::get('member_registration_enabled', '1');
        if (! filter_var($enabled, FILTER_VALIDATE_BOOLEAN)) {
            $message = Setting::get('member_registration_disabled_message', 'Les inscriptions sont temporairement fermées.');
            return view('member.auth.register', ['disabled' => true, 'disabledMessage' => $message]);
        }

        return view('member.auth.register', ['disabled' => false]);
    }

    public function register(Request $request)
    {
        $enabled = Setting::get('member_registration_enabled', '1');
        if (! filter_var($enabled, FILTER_VALIDATE_BOOLEAN)) {
            abort(403, 'Les inscriptions sont désactivées.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $approval = Setting::get('member_registration_approval', 'auto');

        if ($approval === 'auto') {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'member',
                'status'   => 'active',
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('member.profile.edit');
        }

        if ($approval === 'email') {
            $token = Str::random(64);

            $user = User::create([
                'name'                     => $validated['name'],
                'email'                    => $validated['email'],
                'password'                 => Hash::make($validated['password']),
                'role'                     => 'member',
                'status'                   => 'pending',
                'email_verification_token' => $token,
            ]);

            $verifyUrl = route('member.verify-email', ['token' => $token]);

            try {
                app(MailService::class)->sendEmailVerification($user, $verifyUrl);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Verification email failed: ' . $e->getMessage());
            }

            return redirect()->route('member.login')
                ->with('info', 'Inscription réussie ! Vérifiez votre email pour activer votre compte.');
        }

        // admin approval
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'member',
            'status'   => 'pending',
        ]);

        return redirect()->route('member.login')
            ->with('info', 'Votre inscription a été enregistrée. Votre compte sera activé après approbation.');
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (! $user) {
            abort(404, 'Lien de vérification invalide ou déjà utilisé.');
        }

        $user->status                   = 'active';
        $user->email_verification_token = null;
        $user->save();

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->route('member.profile.edit')
            ->with('success', 'Votre email a été vérifié. Bienvenue !');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login');
    }
}

