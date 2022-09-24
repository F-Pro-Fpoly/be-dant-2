<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$param)
    {
        // Pre-Middleware Action

        $response = $next($request);

        // Post-Middleware Action
        foreach($param as $key => $val){
            if(auth()->user()->role->code === $val){
                return $response;   
            }
        }

        return response()->json('Không có quyền truy cập', 401);
    }
}
