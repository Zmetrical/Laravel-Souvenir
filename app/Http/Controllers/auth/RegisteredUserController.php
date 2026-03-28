<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // ── GET /register ─────────────────────────────────────────────────────────
    public function create(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('auth.register');
    }

    // ── POST /register ────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'customer',   // registration always creates customers
                                        // admins are created via db:seed or tinker
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ── Restore pending design if the user was redirected from builder ─────
        // JS will pick up the localStorage key and pre-fill the builder.
        return redirect()->route('account.dashboard')
            ->with('welcome', true);
    }
}