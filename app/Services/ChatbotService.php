<?php

namespace App\Services;

use App\Models\Destinasi;
use App\Models\Hotel;
use App\Models\Ticket;
use App\Models\PaketWisata;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * Process user message and get AI response
     */
    public function processMessage(string $userMessage): array
    {
        try {
            // Get context data from database
            $context = $this->buildContext();
            
            // Build the prompt
            $prompt = $this->buildPrompt($userMessage, $context);
            
            // Call Gemini API
            $response = $this->callGeminiApi($prompt);
            
            // Save to history
            $this->saveToHistory($userMessage, $response);
            
            return [
                'success' => true,
                'response' => $response,
            ];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Chatbot connection error: ' . $e->getMessage());
            return [
                'success' => false,
                'response' => '⏱️ Koneksi timeout. Server AI tidak merespons. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            
            $errorMessage = $e->getMessage();
            
            // Check for quota exceeded error
            if (str_contains($errorMessage, 'quota') || str_contains($errorMessage, 'RESOURCE_EXHAUSTED')) {
                // Provide fallback response with data from database
                return $this->getFallbackResponse($userMessage);
            }
            
            // Check for invalid API key
            if (str_contains($errorMessage, 'API_KEY_INVALID') || str_contains($errorMessage, 'API key not valid')) {
                return [
                    'success' => false,
                    'response' => '🔑 API key tidak valid. Silakan hubungi admin untuk memperbaiki konfigurasi.',
                    'error' => $errorMessage,
                ];
            }
            
            return [
                'success' => false,
                'response' => 'Maaf, terjadi kesalahan: ' . substr($errorMessage, 0, 100),
                'error' => $errorMessage,
            ];
        }
    }

    /**
     * Build context from database
     */
    protected function buildContext(): array
    {
        // Get featured destinations
        $destinations = Destinasi::where('is_featured', true)
            ->orWhere('rating', '>=', 4)
            ->take(10)
            ->get(['nama_destinasi', 'lokasi', 'kategori', 'harga', 'rating', 'deskripsi']);

        // Get available hotels
        $hotels = Hotel::where('status', 'active')
            ->where('kamar_tersedia', '>', 0)
            ->take(10)
            ->get(['nama_hotel', 'lokasi', 'harga_per_malam', 'rating', 'tipe_kamar', 'wifi', 'kolam_renang', 'restoran']);

        // Get available tickets
        $tickets = Ticket::where('aktif', true)
            ->where('tersedia', '>', 0)
            ->take(10)
            ->get(['nama_transportasi', 'jenis_transportasi', 'asal', 'tujuan', 'harga', 'kelas', 'waktu_berangkat']);

        // Get travel packages
        $packages = PaketWisata::where('stok', '>', 0)
            ->take(10)
            ->get(['nama_paket', 'lokasi', 'harga', 'durasi', 'rating', 'deskripsi']);

        return [
            'destinations' => $destinations->toArray(),
            'hotels' => $hotels->toArray(),
            'tickets' => $tickets->toArray(),
            'packages' => $packages->toArray(),
        ];
    }

    /**
     * Build prompt with context
     */
    protected function buildPrompt(string $userMessage, array $context): string
    {
        $destinationsInfo = $this->formatDestinations($context['destinations']);
        $hotelsInfo = $this->formatHotels($context['hotels']);
        $ticketsInfo = $this->formatTickets($context['tickets']);
        $packagesInfo = $this->formatPackages($context['packages']);

        return <<<PROMPT
Kamu adalah TraveGo AI Assistant, asisten virtual untuk platform travel premium Indonesia bernama TraveGo. 
Kamu membantu pengguna menemukan destinasi wisata, hotel, tiket transportasi, dan paket wisata terbaik.

Berikut data terkini dari platform TraveGo:

=== DESTINASI WISATA ===
{$destinationsInfo}

=== HOTEL TERSEDIA ===
{$hotelsInfo}

=== TIKET TRANSPORTASI ===
{$ticketsInfo}

=== PAKET WISATA ===
{$packagesInfo}

INSTRUKSI:
1. Jawab dalam Bahasa Indonesia yang ramah dan profesional
2. Berikan rekomendasi berdasarkan data di atas
3. Jika ditanya tentang sesuatu yang tidak ada di data, katakan bahwa kamu akan membantu mencari alternatif
4. Sertakan harga jika relevan (format: Rp xxx.xxx)
5. Jawab dengan singkat dan informatif (maksimal 3-4 paragraf)
6. Gunakan emoji untuk membuat percakapan lebih menarik
7. Jika user bertanya di luar konteks travel, tetap bantu dengan ramah tapi arahkan kembali ke layanan TraveGo

Pertanyaan pengguna: {$userMessage}

Jawaban:
PROMPT;
    }

    /**
     * Format destinations for prompt
     */
    protected function formatDestinations(array $destinations): string
    {
        if (empty($destinations)) {
            return "Tidak ada data destinasi saat ini.";
        }

        $result = "";
        foreach ($destinations as $dest) {
            $price = number_format($dest['harga'] ?? 0, 0, ',', '.');
            $result .= "- {$dest['nama_destinasi']} ({$dest['lokasi']}) - {$dest['kategori']} - Rating: {$dest['rating']}⭐ - Harga: Rp {$price}\n";
        }
        return $result;
    }

    /**
     * Format hotels for prompt
     */
    protected function formatHotels(array $hotels): string
    {
        if (empty($hotels)) {
            return "Tidak ada data hotel saat ini.";
        }

        $result = "";
        foreach ($hotels as $hotel) {
            $price = number_format($hotel['harga_per_malam'] ?? 0, 0, ',', '.');
            $facilities = [];
            if ($hotel['wifi'] ?? false) $facilities[] = 'WiFi';
            if ($hotel['kolam_renang'] ?? false) $facilities[] = 'Kolam Renang';
            if ($hotel['restoran'] ?? false) $facilities[] = 'Restoran';
            $facilityStr = implode(', ', $facilities) ?: 'Standard';
            $result .= "- {$hotel['nama_hotel']} ({$hotel['lokasi']}) - Rating: {$hotel['rating']}⭐ - Harga: Rp {$price}/malam - Fasilitas: {$facilityStr}\n";
        }
        return $result;
    }

    /**
     * Format tickets for prompt
     */
    protected function formatTickets(array $tickets): string
    {
        if (empty($tickets)) {
            return "Tidak ada data tiket saat ini.";
        }

        $result = "";
        foreach ($tickets as $ticket) {
            $price = number_format($ticket['harga'] ?? 0, 0, ',', '.');
            $result .= "- {$ticket['nama_transportasi']} ({$ticket['jenis_transportasi']}) - {$ticket['asal']} → {$ticket['tujuan']} - Kelas: {$ticket['kelas']} - Harga: Rp {$price}\n";
        }
        return $result;
    }

    /**
     * Format packages for prompt
     */
    protected function formatPackages(array $packages): string
    {
        if (empty($packages)) {
            return "Tidak ada data paket wisata saat ini.";
        }

        $result = "";
        foreach ($packages as $package) {
            $price = number_format($package['harga'] ?? 0, 0, ',', '.');
            $result .= "- {$package['nama_paket']} ({$package['lokasi']}) - Durasi: {$package['durasi']} hari - Rating: {$package['rating']}⭐ - Harga: Rp {$price}\n";
        }
        return $result;
    }

    /**
     * Call Gemini API
     */
    protected function callGeminiApi(string $prompt): string
    {
        $response = Http::timeout(30)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 512,
            ],
            'safetySettings' => [
                [
                    'category' => 'HARM_CATEGORY_HARASSMENT',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
                [
                    'category' => 'HARM_CATEGORY_HATE_SPEECH',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
            ]
        ]);

        if ($response->failed()) {
            $body = $response->json();
            $errorMessage = $body['error']['message'] ?? $response->body();
            Log::error('Gemini API Error: ' . $errorMessage);
            throw new \Exception($errorMessage);
        }

        $data = $response->json();
        
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return $data['candidates'][0]['content']['parts'][0]['text'];
        }

        throw new \Exception('Invalid response format from AI');
    }

    /**
     * Save message to history
     */
    protected function saveToHistory(string $message, string $response): void
    {
        if (Auth::check()) {
            ChatMessage::create([
                'user_id' => Auth::id(),
                'message' => $message,
                'response' => $response,
            ]);
        }
    }

    /**
     * Get chat history for current user
     */
    public function getHistory(int $limit = 20): array
    {
        if (!Auth::check()) {
            return [];
        }

        return ChatMessage::forUser(Auth::id())
            ->orderBy('created_at', 'asc')
            ->take($limit)
            ->get()
            ->toArray();
    }

    /**
     * Clear chat history for current user
     */
    public function clearHistory(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        ChatMessage::forUser(Auth::id())->delete();
        return true;
    }

    /**
     * Get fallback response from database when API is unavailable
     */
    protected function getFallbackResponse(string $userMessage): array
    {
        $message = strtolower($userMessage);
        $response = "🤖 *Mode Offline* - AI sedang tidak tersedia, tapi saya bisa membantu!\n\n";
        
        // Detect user intent and provide relevant data
        if (str_contains($message, 'destinasi') || str_contains($message, 'wisata') || str_contains($message, 'tempat')) {
            $destinations = Destinasi::inRandomOrder()->take(3)->get();
            if ($destinations->count() > 0) {
                $response .= "🗺️ **Rekomendasi Destinasi:**\n";
                foreach ($destinations as $dest) {
                    $price = number_format($dest->harga ?? 0, 0, ',', '.');
                    $response .= "• **{$dest->nama_destinasi}** ({$dest->lokasi}) - ⭐{$dest->rating} - Rp {$price}\n";
                }
                $response .= "\n👉 Kunjungi halaman [Destinasi](/destinasi) untuk info lengkap!";
            }
        } elseif (str_contains($message, 'hotel') || str_contains($message, 'penginapan') || str_contains($message, 'menginap')) {
            $hotels = Hotel::where('status', 'active')->inRandomOrder()->take(3)->get();
            if ($hotels->count() > 0) {
                $response .= "🏨 **Rekomendasi Hotel:**\n";
                foreach ($hotels as $hotel) {
                    $price = number_format($hotel->harga_per_malam ?? 0, 0, ',', '.');
                    $response .= "• **{$hotel->nama_hotel}** ({$hotel->lokasi}) - ⭐{$hotel->rating} - Rp {$price}/malam\n";
                }
                $response .= "\n👉 Kunjungi halaman [Hotel](/hotel) untuk booking!";
            }
        } elseif (str_contains($message, 'tiket') || str_contains($message, 'pesawat') || str_contains($message, 'kereta') || str_contains($message, 'transportasi')) {
            $tickets = Ticket::where('aktif', true)->inRandomOrder()->take(3)->get();
            if ($tickets->count() > 0) {
                $response .= "✈️ **Tiket Tersedia:**\n";
                foreach ($tickets as $ticket) {
                    $price = number_format($ticket->harga ?? 0, 0, ',', '.');
                    $response .= "• **{$ticket->nama_transportasi}** ({$ticket->asal} → {$ticket->tujuan}) - Rp {$price}\n";
                }
                $response .= "\n👉 Kunjungi halaman [Tiket](/tiket) untuk pesan!";
            }
        } elseif (str_contains($message, 'paket') || str_contains($message, 'tour')) {
            $packages = PaketWisata::where('stok', '>', 0)->inRandomOrder()->take(3)->get();
            if ($packages->count() > 0) {
                $response .= "📦 **Paket Wisata Tersedia:**\n";
                foreach ($packages as $paket) {
                    $price = number_format($paket->harga ?? 0, 0, ',', '.');
                    $response .= "• **{$paket->nama_paket}** ({$paket->durasi} hari) - ⭐{$paket->rating} - Rp {$price}\n";
                }
                $response .= "\n👉 Kunjungi halaman [Paket Wisata](/paket) untuk detail!";
            }
        } elseif (str_contains($message, 'promo') || str_contains($message, 'diskon')) {
            $promos = Promo::valid()->inRandomOrder()->take(3)->get();
            if ($promos->count() > 0) {
                $response .= "🎁 **Promo Aktif:**\n";
                foreach ($promos as $promo) {
                    $discount = $promo->discount_type === 'percentage' ? "{$promo->discount_value}%" : "Rp " . number_format($promo->discount_value, 0, ',', '.');
                    $response .= "• **{$promo->code}** - Diskon {$discount}\n";
                }
                $response .= "\n👉 Kunjungi halaman [Promo](/promo) untuk klaim!";
            }
        } else {
            // General response
            $response .= "Saya bisa membantu Anda dengan:\n";
            $response .= "• 🗺️ Destinasi wisata - ketik 'destinasi'\n";
            $response .= "• 🏨 Hotel - ketik 'hotel'\n";
            $response .= "• ✈️ Tiket transportasi - ketik 'tiket'\n";
            $response .= "• 📦 Paket wisata - ketik 'paket'\n";
            $response .= "• 🎁 Promo - ketik 'promo'\n\n";
            $response .= "💡 *Tip: Coba lagi dalam beberapa menit untuk respons AI penuh!*";
        }

        return [
            'success' => true,
            'response' => $response,
            'fallback' => true,
        ];
    }
}
