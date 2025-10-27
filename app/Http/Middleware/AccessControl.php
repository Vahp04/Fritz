<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessControl
{
    public function handle(Request $request, Closure $next)
    {
        $accessPassword = $request->get('access_key');
        $validPassword = 'Fritz4055**';
        
        if ($accessPassword !== $validPassword) {
            return response()->view('acceso-restringido');
        }
        
        return $next($request);
    }
}