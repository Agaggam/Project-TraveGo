@extends('layouts.app')

@section('title', 'Hubungi Kami - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Hubungi Kami</span>
            <h1 class="font-heading text-5xl sm:text-6xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                Kami Siap <span class="gradient-text">Membantu Anda</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-dark-300 max-w-3xl mx-auto leading-relaxed">
                Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda 24/7
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Contact Info -->
            <div>
                <h2 class="font-heading text-3xl font-bold mb-8 text-gray-900 dark:text-white">
                    Informasi <span class="gradient-text">Kontak</span>
                </h2>
                
                <div class="space-y-6">
                    <div class="flex items-start p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Alamat Kantor</h3>
                            <p class="text-gray-500 dark:text-dark-400">Jl. Sudirman No. 123, Jakarta Pusat<br>Indonesia 10210</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-500/20 to-accent-600/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Telepon</h3>
                            <p class="text-gray-500 dark:text-dark-400">+62 812 3456 7890</p>
                            <p class="text-gray-500 dark:text-dark-400">+62 21 1234 5678</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500/20 to-accent-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Email</h3>
                            <p class="text-gray-500 dark:text-dark-400">info@travego.id</p>
                            <p class="text-gray-500 dark:text-dark-400">support@travego.id</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Jam Operasional</h3>
                            <p class="text-gray-500 dark:text-dark-400">Senin - Jumat: 08:00 - 20:00</p>
                            <p class="text-gray-500 dark:text-dark-400">Sabtu - Minggu: 09:00 - 17:00</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl flex items-center justify-center text-gray-500 dark:text-dark-400 hover:text-primary-500 hover:border-primary-500 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl flex items-center justify-center text-gray-500 dark:text-dark-400 hover:text-primary-500 hover:border-primary-500 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl flex items-center justify-center text-gray-500 dark:text-dark-400 hover:text-primary-500 hover:border-primary-500 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl flex items-center justify-center text-gray-500 dark:text-dark-400 hover:text-green-500 hover:border-green-500 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="p-8 rounded-3xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                <h2 class="font-heading text-2xl font-bold mb-6 text-gray-900 dark:text-white">
                    Kirim Pesan
                </h2>
                
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-dark-200 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-dark-900 border border-gray-200 dark:border-dark-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300" placeholder="John Doe">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-dark-200 mb-2">Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-dark-900 border border-gray-200 dark:border-dark-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300" placeholder="john@example.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-dark-200 mb-2">No. Telepon</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-dark-900 border border-gray-200 dark:border-dark-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300" placeholder="+62 812 3456 7890">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-dark-200 mb-2">Subjek</label>
                        <select id="subject" name="subject" class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-dark-900 border border-gray-200 dark:border-dark-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300">
                            <option value="">Pilih Subjek</option>
                            <option value="general">Pertanyaan Umum</option>
                            <option value="booking">Pemesanan Paket</option>
                            <option value="payment">Pembayaran</option>
                            <option value="complaint">Keluhan</option>
                            <option value="partnership">Kerjasama</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-dark-200 mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-dark-900 border border-gray-200 dark:border-dark-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300 resize-none" placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-semibold rounded-xl transition-all duration-300 glow-primary">
                        Kirim Pesan
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Lokasi Kami</span>
            <h2 class="font-heading text-4xl font-bold mt-4 text-gray-900 dark:text-white">
                Kunjungi <span class="gradient-text">Kantor Kami</span>
            </h2>
        </div>
        
        <div class="rounded-3xl overflow-hidden border border-gray-200 dark:border-dark-700">
            <div class="aspect-video bg-gray-200 dark:bg-dark-800 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 dark:text-dark-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-dark-400">Peta lokasi akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">FAQ</span>
            <h2 class="font-heading text-4xl font-bold mt-4 text-gray-900 dark:text-white">
                Pertanyaan yang <span class="gradient-text">Sering Diajukan</span>
            </h2>
        </div>
        
        <div class="space-y-4" x-data="{ open: null }">
            <div class="rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 overflow-hidden">
                <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-heading font-semibold text-gray-900 dark:text-white">Bagaimana cara memesan paket wisata?</span>
                    <svg class="w-5 h-5 text-primary-500 transition-transform" :class="{ 'rotate-180': open === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open === 1" x-collapse class="px-6 pb-6">
                    <p class="text-gray-500 dark:text-dark-400">Anda dapat memesan paket wisata dengan memilih paket yang diinginkan, lalu klik tombol "Pesan Sekarang". Ikuti langkah-langkah pembayaran dan tim kami akan menghubungi Anda untuk konfirmasi.</p>
                </div>
            </div>
            
            <div class="rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 overflow-hidden">
                <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-heading font-semibold text-gray-900 dark:text-white">Metode pembayaran apa saja yang tersedia?</span>
                    <svg class="w-5 h-5 text-primary-500 transition-transform" :class="{ 'rotate-180': open === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open === 2" x-collapse class="px-6 pb-6">
                    <p class="text-gray-500 dark:text-dark-400">Kami menerima berbagai metode pembayaran termasuk transfer bank, kartu kredit/debit, e-wallet (GoPay, OVO, Dana), dan virtual account dari berbagai bank.</p>
                </div>
            </div>
            
            <div class="rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 overflow-hidden">
                <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-heading font-semibold text-gray-900 dark:text-white">Bagaimana kebijakan pembatalan pesanan?</span>
                    <svg class="w-5 h-5 text-primary-500 transition-transform" :class="{ 'rotate-180': open === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open === 3" x-collapse class="px-6 pb-6">
                    <p class="text-gray-500 dark:text-dark-400">Pembatalan dapat dilakukan maksimal 7 hari sebelum tanggal keberangkatan dengan pengembalian dana 100%. Pembatalan 3-6 hari sebelumnya dikenakan biaya 50%. Kurang dari 3 hari tidak dapat dikembalikan.</p>
                </div>
            </div>
            
            <div class="rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 overflow-hidden">
                <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-heading font-semibold text-gray-900 dark:text-white">Apakah paket sudah termasuk asuransi perjalanan?</span>
                    <svg class="w-5 h-5 text-primary-500 transition-transform" :class="{ 'rotate-180': open === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open === 4" x-collapse class="px-6 pb-6">
                    <p class="text-gray-500 dark:text-dark-400">Ya, semua paket wisata kami sudah termasuk asuransi perjalanan dasar. Untuk perlindungan lebih lengkap, Anda dapat menambahkan asuransi premium dengan biaya tambahan.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
