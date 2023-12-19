<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive

{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isActive !== true) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Access denied"
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
