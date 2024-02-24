<?php

namespace App\Http\Middleware;

use App\Traits\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('api')->user())
        {
            if(auth()->guard('api')->user()->isAdmin())
            {
                return $next($request);
            }
            return response('You are not allowed to');
        }

        return response('You are not unauthorized');
    }
}
