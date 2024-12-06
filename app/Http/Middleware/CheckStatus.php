<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah status pengguna adalah 'banned'
        if ($user && $user->status === 'banned') {
            Auth::logout();  // Logout pengguna yang dibanned
            return redirect()->route('login')->with('error', 'Your account has been banned. Ask adminitrator for solution');
        }

        return $next($request);
    }
}
