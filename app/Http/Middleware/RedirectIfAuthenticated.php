<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * Redirect authenticated users away from guest pages (login/register)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Check JWT token from cookie first
        $token = $request->cookie('jwt_token');
        
        if ($token) {
            try {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();
                
                if ($user) {
                    if ($user->isAdmin()) {
                        return redirect('/admin/dashboard');
                    }
                    return redirect(RouteServiceProvider::HOME);
                }
            } catch (JWTException $e) {
                // Token invalid, continue to guest page
            }
        }
        
        // Fallback to default guard check
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /** @var \App\Models\User $user */
                $user = Auth::guard($guard)->user();
                if ($user && $user->isAdmin()) {
                    return redirect('/admin/dashboard');
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
