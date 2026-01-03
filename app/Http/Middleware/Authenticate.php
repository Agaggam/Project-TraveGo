<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request - support JWT from cookie
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Try to get token from cookie first
        $token = $request->cookie('jwt_token');
        
        if ($token) {
            try {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();
                
                if ($user) {
                    auth()->setUser($user);
                    return $next($request);
                }
            } catch (JWTException $e) {
                // Token invalid, continue to redirectTo
            }
        }
        
        // Fall back to parent behavior
        $this->authenticate($request, $guards);

        return $next($request);
    }
    
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
