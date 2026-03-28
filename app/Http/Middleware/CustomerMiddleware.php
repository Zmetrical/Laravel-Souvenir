<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            // Preserve the intended URL so we can return after login
            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        }

        // Admins should not be browsing customer pages
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}