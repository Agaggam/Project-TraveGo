<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Promo;
use App\Models\Ticket;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ValidationController extends Controller
{
    /**
     * Check if email is available (for registration)
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => 'Format email tidak valid'
            ]);
        }
        
        $exists = User::where('email', $request->email)->exists();
        
        return response()->json([
            'valid' => !$exists,
            'available' => !$exists,
            'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
        ]);
    }
    
    /**
     * Check password strength
     */
    public function checkPassword(Request $request)
    {
        $password = $request->password;
        
        $strength = 0;
        $suggestions = [];
        
        if (strlen($password) >= 8) {
            $strength += 25;
        } else {
            $suggestions[] = 'Minimal 8 karakter';
        }
        
        if (preg_match('/[a-z]/', $password)) {
            $strength += 25;
        } else {
            $suggestions[] = 'Tambahkan huruf kecil';
        }
        
        if (preg_match('/[A-Z]/', $password)) {
            $strength += 25;
        } else {
            $suggestions[] = 'Tambahkan huruf besar';
        }
        
        if (preg_match('/[0-9]/', $password)) {
            $strength += 25;
        } else {
            $suggestions[] = 'Tambahkan angka';
        }
        
        $level = 'weak';
        if ($strength >= 75) $level = 'strong';
        elseif ($strength >= 50) $level = 'medium';
        
        return response()->json([
            'strength' => $strength,
            'level' => $level,
            'suggestions' => $suggestions,
            'valid' => $strength >= 50
        ]);
    }
    
    /**
     * Check ticket availability
     */
    public function checkTicketAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'available' => false,
                'message' => 'Data tidak valid'
            ]);
        }
        
        $ticket = Ticket::find($request->ticket_id);
        
        if (!$ticket || !$ticket->aktif) {
            return response()->json([
                'available' => false,
                'message' => 'Tiket tidak tersedia'
            ]);
        }
        
        $available = $ticket->tersedia >= $request->quantity;
        
        return response()->json([
            'available' => $available,
            'remaining' => $ticket->tersedia,
            'message' => $available ? 'Tiket tersedia' : 'Stok tidak mencukupi (tersisa: ' . $ticket->tersedia . ')'
        ]);
    }
    
    /**
     * Check hotel room availability
     */
    public function checkHotelAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|in:standard,deluxe,suite',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'available' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ]);
        }
        
        $hotel = Hotel::find($request->hotel_id);
        
        if (!$hotel || $hotel->status !== 'active') {
            return response()->json([
                'available' => false,
                'message' => 'Hotel tidak tersedia'
            ]);
        }
        
        // Get room count based on type
        $roomColumn = 'kamar_' . $request->room_type;
        $availableRooms = $hotel->$roomColumn ?? 0;
        
        // Calculate nights
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        
        // Get price
        $priceColumn = 'harga_' . $request->room_type;
        $pricePerNight = $hotel->$priceColumn ?? $hotel->harga_per_malam;
        $totalPrice = $pricePerNight * $nights;
        
        return response()->json([
            'available' => $availableRooms > 0,
            'rooms_available' => $availableRooms,
            'nights' => $nights,
            'price_per_night' => $pricePerNight,
            'total_price' => $totalPrice,
            'message' => $availableRooms > 0 ? 'Kamar tersedia' : 'Kamar tidak tersedia'
        ]);
    }
    
    /**
     * Validate booking date
     */
    public function validateDate(Request $request)
    {
        $date = $request->date;
        $type = $request->type ?? 'departure'; // departure, check_in, check_out
        
        try {
            $parsedDate = Carbon::parse($date);
            $today = Carbon::today();
            
            $isValid = false;
            $message = '';
            
            switch ($type) {
                case 'departure':
                    $isValid = $parsedDate->isAfter($today);
                    $message = $isValid ? 'Tanggal valid' : 'Tanggal harus di masa depan';
                    break;
                    
                case 'check_in':
                    $isValid = $parsedDate->isAfter($today) || $parsedDate->isSameDay($today);
                    $message = $isValid ? 'Tanggal valid' : 'Check-in tidak boleh di masa lalu';
                    break;
                    
                case 'check_out':
                    $checkIn = $request->check_in ? Carbon::parse($request->check_in) : null;
                    if ($checkIn) {
                        $isValid = $parsedDate->isAfter($checkIn);
                        $message = $isValid ? 'Tanggal valid' : 'Check-out harus setelah check-in';
                    } else {
                        $isValid = $parsedDate->isAfter($today);
                        $message = $isValid ? 'Tanggal valid' : 'Tanggal tidak valid';
                    }
                    break;
            }
            
            return response()->json([
                'valid' => $isValid,
                'date' => $parsedDate->format('Y-m-d'),
                'formatted' => $parsedDate->format('d F Y'),
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Format tanggal tidak valid'
            ]);
        }
    }
}
