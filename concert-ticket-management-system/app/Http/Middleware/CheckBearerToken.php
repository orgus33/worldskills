<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(["message" => "Bearer token required"], 401);
        }

        $personalAccessToken = PersonalAccessToken::where('token', $token)->first();

        if (!$personalAccessToken) {
            return response()->json(["message" => "Invalid Bearer token"], 401);
        }

        $user = User::find($personalAccessToken->user_id);

        if (!$user) {
            return response()->json(["message" => "Invalid Bearer token"], 401);
        }

        $request->attributes->set('user', $user);


        return $next($request);
    }
}
