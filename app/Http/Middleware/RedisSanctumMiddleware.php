<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class RedisSanctumMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $tokenKey = 'sanctum_token:' . $token;
        $tokenData = Redis::get($tokenKey);

        if (!$tokenData) {
            $accessToken = PersonalAccessToken::findToken($token);

            if (!$accessToken || !$accessToken->tokenable) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            $tokenData = [
                'id' => $accessToken->id,
                'tokenable_id' => $accessToken->tokenable_id,
                'tokenable_type' => $accessToken->tokenable_type,
                'name' => $accessToken->name,
                'abilities' => $accessToken->abilities,
                'last_used_at' => $accessToken->last_used_at,
                'created_at' => $accessToken->created_at,
                'updated_at' => $accessToken->updated_at,
            ];

            Redis::set($tokenKey, json_encode($tokenData), 'EX', 350);
        } else {
            $tokenData = json_decode($tokenData, true);
        }

        $userModel = $tokenData['tokenable_type'];
        $user = (new $userModel)->find($tokenData['tokenable_id']);

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Set the authenticated user in the request and Auth facade
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        Auth::setUser($user);

        return $next($request);
    }
}
