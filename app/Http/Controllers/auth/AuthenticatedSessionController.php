<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // ── GET /login ────────────────────────────────────────────────────────────
    public function create(): View|RedirectResponse
    {
        // Already logged in → go to the right dashboard
        if (auth()->check()) {
            return $this->roleRedirect();
        }

        return view('auth.login');
    }

    // ── POST /login ───────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ]);
        }

        $request->session()->regenerate();

        // ── Check for a pending design to restore after login ─────────────────
        // The builder stores design JSON in the session before redirecting
        // to login. After login we send the user back to the builder so
        // the JS can restore it from localStorage.
        if ($intended = $request->session()->get('url.intended')) {
            return redirect($intended);
        }

        return $this->roleRedirect();
    }

    // ── DELETE /logout ────────────────────────────────────────────────────────
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ── Redirect based on role ────────────────────────────────────────────────
    private function roleRedirect(): RedirectResponse
    {
        return match (auth()->user()->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            default    => redirect()->route('account.dashboard'),
        };
    }
}