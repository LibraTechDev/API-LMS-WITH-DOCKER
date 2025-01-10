<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'teacher') {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden: Only teachers are allowed to perform this action.',
            ], 403);
        }

        return $next($request);
    }
}