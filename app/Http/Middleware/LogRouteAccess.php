<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteLog;

class LogRouteAccess
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
        $response = $next($request);
 // Hanya log jika metode adalah POST, PUT, PATCH, DELETE
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            RouteLog::create([
                'user_id' => Auth::id(),
                'method' => $request->method(),
                'uri' => $request->path(),
                'route' => optional($request->route())->getName(),
                'ip' => $request->ip(),
                'logged_at' => now(),
            ]);
        }

        return $response;
    }
}
