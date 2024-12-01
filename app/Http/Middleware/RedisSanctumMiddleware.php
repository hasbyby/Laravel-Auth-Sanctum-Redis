<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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

        $request->setUserResolver(function () use ($tokenData) {
            $model = $tokenData['tokenable_type'];
            return (new $model)->find($tokenData['tokenable_id']);
        });

        return $next($request);
    }
}
