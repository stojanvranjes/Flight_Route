<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        if ($request->user()->role->name == 'admin') {
            return $next($request);
        }

        return response()->json([
            "error" => 'Error',
            "message" => 'Only Admin can do this action!',
        ], 403);

    }
}
