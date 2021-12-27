<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class Adminrole
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
        
            $segment = request()->segment(2);

            $roles = Auth::check() ? Auth::user()->roles->pluck('slug')->toArray() : [];
            if (in_array('super_admin', $roles)) {
                return $next($request);
            }

            if (in_array('vendor', $roles)) {
                return $next($request);
            }

            if (in_array('admin', $roles)) {
                $user_access = json_decode(auth()->user()->access_level);
                if (in_array($segment, $user_access)) {
                    // dd('hi');
                    // dd(in_array($segment, $user_access));
                    return $next($request);
                }
                return redirect()->route('dashboard')->with('message', 'You dont have admin access');
            }
            return redirect()->route('dashboard');
        
    }
}
