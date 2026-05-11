<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // reject if request body is not a valid JSON
        if (!json_validate($request->getContent())) {
            return errorResponse('Request body must be a valid JSON', 400);
        }

        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
