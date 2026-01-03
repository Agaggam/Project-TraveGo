<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class SetAuthFromJwt
{
    /**
     * Set authenticated user from JWT cookie for ALL requests
     * This makes @auth and @guest directives work correctly with JWT
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');
        
        if ($token) {
            try {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();
                
                if ($user) {
                    auth()->setUser($user);
                }
            } catch (JWTException $e) {
                // Token invalid, continue as guest
            }
        }
        
        return $next($request);
    }
}
