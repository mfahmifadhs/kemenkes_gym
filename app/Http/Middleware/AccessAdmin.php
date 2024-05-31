<?php

namespace App\Http\Middleware;

use App\Model\submissionModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $status)
    {
        if(Auth::user() == null){
            return redirect('/')->with('failed', 'You don`t have access!');
        }

        $role = Auth::user()->role_id;

        if ($status == 'admin')
        {
            if ($role == 1 || $role == 2 || $role == 3) {
                return $next($request);
            } else {
                return back()->with('failed', 'You don`t have access!');
            }
        }

        return $next($request);
    }
}
