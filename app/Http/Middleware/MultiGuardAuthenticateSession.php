<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultiGuardAuthenticateSession
{
    /**
     * Handle an incoming request.
     *
     * This middleware only validates the session for the 'web' guard (users).
     * It allows the 'admin' guard to maintain independent sessions without
     * interfering with user sessions, enabling simultaneous user/admin login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Skip validation if no user is authenticated on the 'web' guard
        if (! $request->user('web')) {
            return $next($request);
        }

        // Validate that the authenticated user session is still valid
        $sessionKey = 'login_session_id_' . sha1(static::class);
        
        try {
            if (! $request->session()->has($sessionKey)) {
                // First time user logs in on this request cycle, store the user ID
                $request->session()->put($sessionKey, Auth::guard('web')->user()->id);
                return $next($request);
            }

            // Verify the session user ID hasn't changed (detecting session hijacking or logout)
            $storedUserId = $request->session()->get($sessionKey);
            $currentUserId = Auth::guard('web')->user()->id;
            
            if ($storedUserId !== $currentUserId) {
                Auth::guard('web')->logout();
                return redirect('/login');
            }
        } catch (\Exception $e) {
            // If any error occurs with session validation, allow the request
            // This prevents blocking login/register pages
            return $next($request);
        }

        return $next($request);
    }
}