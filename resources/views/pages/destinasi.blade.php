@extends('layouts.app')

@section('title', 'Destinasi Populer - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Destinasi Populer</span>
            <h1 class="font-heading text-5xl sm:text-6xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                Jelajahi <span class="gradient-text">Keindahan Indonesia</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-dark-300 max-w-3xl mx-auto leading-relaxed">
                Temukan destinasi wisata paling menakjubkan dari Sabang sampai Merauke
            </p>
        </div>
    </div>
</section>

<!-- Featured Destinations -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Pilihan Utama</span>
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 text-gray-900 dark:text-white">
                Destinasi <span class="gradient-text">Terfavorit</span>
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Bali -->
            <div class="group relative rounded-3xl overflow-hidden card-hover transition-all duration-300">
                <div class="aspect-[4/5] bg-gradient-to-br from-primary-600 to-accent-600">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white/80 text-sm">Indonesia</span>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-white mb-2">Bali</h3>
                    <p class="text-white/70 text-sm mb-4">Pulau Dewata dengan pantai eksotis, pura megah, dan budaya yang memukau</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-white ml-1 text-sm">4.9</span>
                        </div>
                        <span class="text-primary-400 text-sm font-medium">20+ Paket</span>
                    </div>
                </div>
            </div>

            <!-- Raja Ampat -->
            <div class="group relative rounded-3xl overflow-hidden card-hover transition-all duration-300">
                <div class="aspect-[4/5] bg-gradient-to-br from-cyan-600 to-blue-600">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white/80 text-sm">Papua Barat</span>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-white mb-2">Raja Ampat</h3>
                    <p class="text-white/70 text-sm mb-4">Surga bawah laut dengan keanekaragaman hayati laut terkaya di dunia</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-white ml-1 text-sm">4.9</span>
                        </div>
                        <span class="text-primary-400 text-sm font-medium">15+ Paket</span>
                    </div>
                </div>
            </div>

            <!-- Yogyakarta -->
            <div class="group relative rounded-3xl overflow-hidden card-hover transition-all duration-300">
                <div class="aspect-[4/5] bg-gradient-to-br from-amber-600 to-orange-600">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white/80 text-sm">Jawa Tengah</span>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-white mb-2">Yogyakarta</h3>
                    <p class="text-white/70 text-sm mb-4">Kota budaya dengan Candi Borobudur, Prambanan, dan kuliner legendaris</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-white ml-1 text-sm">4.8</span>
                        </div>
                        <span class="text-primary-400 text-sm font-medium">25+ Paket</span>
                    </div>
                </div>
            </div>

            <!-- Lombok -->
            <div class="group relative rounded-3xl overflow-hidden card-hover transition-all duration-300">
                <div class="aspect-[4/5] bg-gradient-to-br from-emerald-600 to-teal-600">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white/80 text-sm">NTB</span>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-white mb-2">Lombok</h3>
                    <p class="text-white/70 text-sm mb-4">Pantai perawan, Gunung Rinjani, dan Gili yang mempesona</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-white ml-1 text-sm">4.8</span>
                        </div>
                        <span class="text-primary-400 text-sm font-medium">18+ Paket</span>
                    </div>
                </div>
            </div>

            <!-- Komodo -->
            <div class="group relative rounded-3xl overflow-hidden card-hover transition-all duration-300">
                <div class="aspect-[4/5] bg-gradient-to-br from-rose-600 to-pink-600">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white/80 text-sm">NTT</span>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-white mb-2">Labuan Bajo & Komodo</h3>
                    <p class="text-white/70 text-sm mb-4">Rumah komodo, pantai pink, dan pemandangan sunset terbaik</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-white ml-1 text-sm">4.9</span>
                        </div>
                        <span class="text-primary-400 text-sm font-medium">12+ Paket</span>
                    </div>
                </div>
            </div>

            <!-- Bandung -->
            <div class="group relative rounded-3xl overflow-hidden card-hover transition-all duration-300">
                <div class="aspect-[4/5] bg-gradient-to-br from-violet-600 to-purple-600">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-white/80 text-sm">Jawa Barat</span>
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-white mb-2">Bandung</h3>
                    <p class="text-white/70 text-sm mb-4">Kota kembang dengan udara sejuk, kawah putih, dan factory outlet</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-white ml-1 text-sm">4.7</span>
                        </div>
                        <span class="text-primary-400 text-sm font-medium">22+ Paket</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Kategori Wisata</span>
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 text-gray-900 dark:text-white">
                Pilih <span class="gradient-text">Tipe Petualangan</span>
            </h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Pantai & Laut</h3>
                <p class="text-sm text-gray-500 dark:text-dark-400">35+ Destinasi</p>
            </div>
            
            <div class="p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Gunung & Alam</h3>
                <p class="text-sm text-gray-500 dark:text-dark-400">28+ Destinasi</p>
            </div>
            
            <div class="p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Budaya & Sejarah</h3>
                <p class="text-sm text-gray-500 dark:text-dark-400">20+ Destinasi</p>
            </div>
            
            <div class="p-6 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Honeymoon</h3>
                <p class="text-sm text-gray-500 dark:text-dark-400">15+ Destinasi</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-heading text-4xl sm:text-5xl font-bold mb-6 text-gray-900 dark:text-white">
            Temukan <span class="gradient-text">Paket Terbaik</span>
        </h2>
        <p class="text-gray-600 dark:text-dark-300 text-lg mb-10 max-w-2xl mx-auto">
            Jelajahi paket wisata lengkap kami untuk destinasi impian Anda
        </p>
        <a href="{{ route('paket.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-semibold rounded-xl transition-all duration-300 text-lg glow-primary">
            Lihat Semua Paket
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>
</section>
@endsection
