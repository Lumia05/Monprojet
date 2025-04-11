<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()) 
        {
            $user = Auth::user() ;

            if($user->role !== 'super_admin' && $user->role !== 'admin')
            {
                if($user->role === 'employee')
                {
                    return redirect('/employee');
                }
                Auth::logout();
                return redirect('/')->with('error' , 'Unauthorized access. You have been logged out...');
            } 
        }else {
            return redirect('/login');
        }

        return $next($request);
    }
}
