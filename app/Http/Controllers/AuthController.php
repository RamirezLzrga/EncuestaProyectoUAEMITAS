<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Log Activity
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'action' => 'login',
                'description' => 'Inicio de sesión exitoso',
                'type' => 'auth',
                'ip_address' => $request->ip()
            ]);

            $user = Auth::user();

            $target = $user && $user->role === 'admin'
                ? route('dashboard')
                : route('editor.dashboard');

            return redirect()->intended($target);
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Log Activity
        ActivityLog::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'action' => 'register',
            'description' => 'Nuevo usuario registrado',
            'type' => 'user',
            'ip_address' => $request->ip()
        ]);

        $target = $user && $user->role === 'admin'
            ? route('dashboard')
            : route('editor.dashboard');

        return redirect($target);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar_url' => 'nullable|url',
        ]);

        $user->name = $validated['name'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if (array_key_exists('avatar_url', $validated)) {
            $user->avatar_url = $validated['avatar_url'] ?: null;
        }

        $user->save();

        ActivityLog::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'action' => 'update_profile',
            'description' => 'Actualizó su perfil',
            'type' => 'user',
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente.');
    }

    public function logout(Request $request)
    {
        // Log Activity before logout
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'action' => 'logout',
                'description' => 'Cierre de sesión',
                'type' => 'auth',
                'ip_address' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
