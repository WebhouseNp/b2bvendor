<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class Vendor
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
        $roles = Auth::check() ? Auth::user()->roles->pluck('slug')->toArray() : [];

        if (in_array('vendor', $roles)) {
        return $next($request);
        }

        if (in_array('admin', $roles) || in_array('super_admin', $roles)) {
            return redirect()->route('dashboard');
            }
        return $next($request);
    }
}
