<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ipaddress;
use Illuminate\Support\Facades\DB;

class BlockIpAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip IP blocking in local environment to allow development access
        if (app()->environment('local')) {
            return $next($request);
        }
        $ipaddress = DB::table('ipaddresses')->pluck('ipaddress');
        $iparrays = $ipaddress->toArray();
        $userip = $request->ip();
        // Allow common local IPs explicitly
        $localIps = ['127.0.0.1', '::1'];
        if (in_array($userip, $localIps)) {
            return $next($request);
        }
        if (in_array($userip, $iparrays)) {
            abort(403, "You are restricted to access the site.");
        }
        return $next($request);
    }
}
