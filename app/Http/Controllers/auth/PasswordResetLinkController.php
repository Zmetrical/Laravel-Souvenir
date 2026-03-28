<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    // ── GET /forgot-password ──────────────────────────────────────────────────
    public function create(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('auth.forgot-password');
    }

    // ── POST /forgot-password ─────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Laravel will check if the email exists and send the reset link.
        // We always return the same "sent" status so we don't leak whether
        // an email is registered (security best practice).
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}