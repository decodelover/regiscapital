<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureKycIsCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Do not block dashboard access for pending/unverified KYC.
        // KYC should be visible as a status indicator in the UI.
        if ($user && (int) $user->pinstatus !== 0 && ! $request->routeIs('pin', 'pinstatus')) {
            return redirect()->route('pin');
        }

        return $next($request);
    }
}
