<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // DEBUG 1: Cek apakah User terdeteksi Login?
        if (! $request->user()) {
            // Kita return JSON biar bisa dibaca di Inspect Element > Network
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User belum login atau Session habis.',
                    'debug_info' => 'Auth::user() is null'
                ], 401);
            }
            return redirect()->route('login');
        }

        // DEBUG 2: Cek Role User vs Role yang Diizinkan
        // Kita paksa semua jadi huruf kecil (strtolower) biar aman
        $userRole = strtolower($request->user()->role);

        // Bersihkan role yang diizinkan (hilangkan spasi, jadi huruf kecil)
        $allowedRoles = array_map(function($r) {
            return strtolower(trim($r));
        }, $roles);

        if (! in_array($userRole, $allowedRoles)) {
            // Return JSON detail kenapa ditolak
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role Anda tidak diizinkan.',
                    'debug_user_role' => $userRole, // Ini role user dari database
                    'debug_allowed' => $allowedRoles // Ini role yang diminta route
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
