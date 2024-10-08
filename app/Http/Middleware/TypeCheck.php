<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeCheck
{
    use ApiResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, array ...$types): Response
    {
        $user = $request->user();

        if (! $user) {
            return $this->unauthorizedResponse(
                message: "unauthenticated"
            );
        }

        if (! in_array($user->type, $types)) {
            $strTypes = implode(', ', $types);
            return $this->badResponse(
                message: "your account type is {$user->type} not in {$strTypes}"
            );
        }

        return $next($request);
    }
}
