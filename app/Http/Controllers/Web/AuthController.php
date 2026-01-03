<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request with JWT
     */
    public function login(Request $request): RedirectResponse
    {
        $start = microtime(true);
        \Log::info('LOGIN START');

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        \Log::info('VALIDATE: ' . round((microtime(true) - $start) * 1000) . 'ms');

        $key = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Coba lagi dalam beberapa menit.',
            ])->onlyInput('email');
        }
        \Log::info('RATE LIMITER: ' . round((microtime(true) - $start) * 1000) . 'ms');

        $credentials = $request->only('email', 'password');

        try {
            $attemptStart = microtime(true);
            if (!$token = JWTAuth::attempt($credentials)) {
                \Log::info('JWT ATTEMPT FAILED: ' . round((microtime(true) - $attemptStart) * 1000) . 'ms');
                RateLimiter::hit($key, 60);
                return back()->withErrors([
                    'email' => 'Email atau password salah.',
                ])->onlyInput('email');
            }
            \Log::info('JWT ATTEMPT SUCCESS: ' . round((microtime(true) - $attemptStart) * 1000) . 'ms');
            \Log::info('TOTAL LOGIN: ' . round((microtime(true) - $start) * 1000) . 'ms');
        } catch (JWTException $e) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat login. Coba lagi.',
            ])->onlyInput('email');
        }

        RateLimiter::clear($key);
        
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // Set remember token expiry
        $ttl = $request->boolean('remember') ? 60 * 24 * 14 : config('jwt.ttl', 60); // 14 days if remember, else default
        
        // Create cookie
        $cookie = cookie(
            'jwt_token',
            $token,
            $ttl,
            '/',
            null,
            config('app.env') === 'production',
            true, // httpOnly
            false,
            'Lax'
        );
        
        if ($user->isAdmin()) {
            // TEMPORARY TEST: redirect ke home dulu untuk test apakah dashboard yang lambat
            return redirect()->route('home')->withCookie($cookie);
            // return redirect()->route('admin.dashboard')->withCookie($cookie);
        }

        return redirect()->route('home')->withCookie($cookie);
    }

    /**
     * Show register form
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle register request with JWT
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user',
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);
        
        // Create cookie
        $cookie = cookie(
            'jwt_token',
            $token,
            config('jwt.ttl', 60),
            '/',
            null,
            config('app.env') === 'production',
            true,
            false,
            'Lax'
        );

        return redirect('/')->with('success', 'Akun berhasil dibuat!')->withCookie($cookie);
    }

    /**
     * Handle logout request - invalidate JWT token
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            // Get token from cookie
            $token = $request->cookie('jwt_token');
            
            if ($token) {
                JWTAuth::setToken($token);
                JWTAuth::invalidate();
            }
        } catch (JWTException $e) {
            // Token already invalid, continue
        }

        // Clear the cookie
        $cookie = cookie()->forget('jwt_token');

        return redirect('/')->withCookie($cookie);
    }

    /**
     * Refresh JWT token
     */
    public function refreshToken(Request $request)
    {
        try {
            $token = $request->cookie('jwt_token');
            
            if (!$token) {
                return response()->json(['error' => 'No token provided'], 401);
            }
            
            JWTAuth::setToken($token);
            $newToken = JWTAuth::refresh();
            
            $cookie = cookie(
                'jwt_token',
                $newToken,
                config('jwt.ttl', 60),
                '/',
                null,
                config('app.env') === 'production',
                true,
                false,
                'Lax'
            );
            
            return response()->json([
                'success' => true,
                'token' => $newToken
            ])->withCookie($cookie);
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token refresh failed'], 401);
        }
    }
}
