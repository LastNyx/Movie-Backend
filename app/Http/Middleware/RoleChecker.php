<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use redirect;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
      {

        $roles = auth('sanctum')->check() ? auth('sanctum')->user()->role_id : '';

           if ($roles != 1) {
               return response()->json(['message'=>'Unauthorized','response'=>Response::HTTP_UNAUTHORIZED]);
           }

           return $next($request);
     }
}
