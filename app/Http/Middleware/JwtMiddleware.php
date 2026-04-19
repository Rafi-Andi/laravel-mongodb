<?php

namespace App\Http\Middleware;

use App\Helpers\JwtHelper;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
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
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $decoded = JwtHelper::decode($token);
            $user = User::find($decoded->sub);

            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan'], 401);
            }

            $request->attributes->set('user', $user);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Token tidak valid atau sudah kedaluwarsa'], 401);
        }

        return $next($request);
    }
}
