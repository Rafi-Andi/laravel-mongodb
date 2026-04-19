<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function encode($user)
    {
        $payload = [
            'iss' => 'laravel-12-api',
            'sub' => (string) $user->_id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + env('JWT_TTL', 3600),
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public static function decode($token)
    {
        return JWT::decode(
            $token,
            new Key(env('JWT_SECRET'), 'HS256')
        );
    }
}
