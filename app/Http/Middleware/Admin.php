<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Admin
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
        if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'super_admin'){
            return response()->json([
                'success' => false,
                'message' => 'You are not an admin'
            ], 403);
        }
        Log::info("Middleware Admin");
        return $next($request);
    }
}
