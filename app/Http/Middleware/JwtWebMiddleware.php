<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtWebMiddleware
{
    /**
     * Handle an incoming request.
     * Untuk web requests, JWT token dibaca dari HttpOnly cookie
     */
    public function handle(Request $request, Closure $next)
    {
        // Coba ambil token dari cookie terlebih dahulu
        $token = $request->cookie('jwt_token');
        
        // Jika tidak ada di cookie, coba dari header (untuk AJAX)
        if (!$token) {
            $token = $request->bearerToken();
        }
        
        if (!$token) {
            return $this->redirectToLogin($request);
        }
        
        try {
            // Set token dan authenticate
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
            
            if (!$user) {
                return $this->redirectToLogin($request);
            }
            
            // Set user ke auth
            auth()->setUser($user);
            
            // Check if token needs refresh (if less than 15 minutes remaining)
            $payload = JWTAuth::getPayload();
            $exp = $payload->get('exp');
            $now = time();
            $refreshThreshold = 15 * 60; // 15 minutes
            
            if (($exp - $now) < $refreshThreshold) {
                try {
                    $newToken = JWTAuth::refresh();
                    // Token akan diupdate di response
                    $request->attributes->set('new_jwt_token', $newToken);
                } catch (JWTException $e) {
                    // Token tidak bisa di-refresh, continue dengan token lama
                }
            }
            
        } catch (TokenExpiredException $e) {
            // Coba refresh token
            try {
                $newToken = JWTAuth::refresh();
                $request->attributes->set('new_jwt_token', $newToken);
                JWTAuth::setToken($newToken);
                $user = JWTAuth::authenticate();
                auth()->setUser($user);
            } catch (JWTException $e) {
                return $this->redirectToLogin($request, 'Sesi Anda telah berakhir. Silakan login kembali.');
            }
        } catch (TokenInvalidException $e) {
            return $this->redirectToLogin($request, 'Token tidak valid.');
        } catch (JWTException $e) {
            return $this->redirectToLogin($request, 'Terjadi kesalahan autentikasi.');
        }
        
        $response = $next($request);
        
        // Update cookie jika token di-refresh
        if ($request->attributes->has('new_jwt_token')) {
            $newToken = $request->attributes->get('new_jwt_token');
            $response = $this->attachTokenCookie($response, $newToken);
        }
        
        return $response;
    }
    
    /**
     * Redirect ke halaman login
     */
    protected function redirectToLogin(Request $request, ?string $message = null)
    {
        // Hapus cookie jika ada
        $cookie = cookie()->forget('jwt_token');
        
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized', 'message' => $message], 401)->withCookie($cookie);
        }
        
        if ($message) {
            return redirect()->route('login')->with('error', $message)->withCookie($cookie);
        }
        
        return redirect()->route('login')->withCookie($cookie);
    }
    
    /**
     * Attach JWT token ke cookie dalam response
     */
    protected function attachTokenCookie($response, string $token)
    {
        $ttl = config('jwt.ttl', 60); // dalam menit
        
        $cookie = cookie(
            'jwt_token',
            $token,
            $ttl,
            '/',
            null,
            config('app.env') === 'production', // secure in production
            true, // httpOnly
            false,
            'Lax' // sameSite
        );
        
        return $response->withCookie($cookie);
    }
}
