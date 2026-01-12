<?php

namespace App\Http\Middleware;



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'agent') {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}
