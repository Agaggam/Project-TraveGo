@extends('layouts.admin')

@section('title', 'Detail Hotel - ' . $hotel->nama_hotel)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.hotels.index') }}" class="w-12 h-12 bg-white dark:bg-dark-900 rounded-2xl flex items-center justify-center shadow-sm border border-gray-100 dark:border-dark-800 text-gray-400 hover:text-primary-500 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ $hotel->nama_hotel }}</h1>
                    <div class="flex items-center mt-1">
                        <div class="flex items-center text-yellow-500 text-xs mr-3">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $hotel->rating ? '' : 'text-gray-200 dark:text-dark-700' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i>{{ $hotel->lokasi }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-bold transition-all duration-300 shadow-lg glow-primary">
                    <i class="fas fa-edit mr-2"></i>Edit Hotel
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Image and Description -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-dark-900 rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-100 dark:border-dark-800">
                    @if($hotel->foto)
                    <img src="{{ asset('storage/' . $hotel->foto) }}" class="w-full h-96 object-cover" alt="{{ $hotel->nama_hotel }}">
                    @else
                    <div class="w-full h-96 bg-gray-100 dark:bg-dark-800 flex flex-col items-center justify-center">
                        <i class="fas fa-hotel text-6xl text-gray-300 mb-4"></i>
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">No Image Available</span>
                    </div>
                    @endif
                    
                    <div class="p-10">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tentang Hotel</h3>
                        <p class="text-gray-600 dark:text-dark-300 leading-relaxed text-lg">
                            {{ $hotel->deskripsi ?? 'Tidak ada deskripsi tersedia untuk hotel ini.' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-900 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-dark-800">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Fasilitas Tersedia</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach(['wifi' => 'Free WiFi', 'kolam_renang' => 'Swimming Pool', 'restoran' => 'Fine Dining', 'gym' => 'Fitness Center', 'parkir' => 'Free Parking'] as $field => $label)
                        <div class="flex items-center p-4 rounded-2xl {{ $hotel->$field ? 'bg-primary-500/10' : 'bg-gray-50/50 dark:bg-dark-800/50 opacity-40' }}">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ $hotel->$field ? 'bg-primary-500 text-white shadow-lg' : 'bg-gray-200 dark:bg-dark-700 text-gray-400' }}">
                                <i class="fas fa-{{ $field == 'parkir' ? 'car' : ($field == 'restoran' ? 'utensils' : ($field == 'kolam_renang' ? 'swimmer' : ($field == 'gym' ? 'dumbbell' : 'wifi'))) }} text-sm"></i>
                            </div>
                            <span class="text-sm font-bold {{ $hotel->$field ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Stats and Info -->
            <div class="space-y-8">
                <div class="bg-primary-500 rounded-[2.5rem] p-8 text-white shadow-xl glow-primary">
                    <p class="text-primary-100 font-medium uppercase tracking-widest text-[10px] mb-2">Harga Mulai Dari</p>
                    <div class="flex items-baseline mb-6">
                        <span class="text-4xl font-black">Rp {{ number_format($hotel->harga_per_malam, 0, ',', '.') }}</span>
                        <span class="ml-2 text-primary-100">/ malam</span>
                    </div>
                    
                    <div class="space-y-4 pt-6 border-t border-white/20">
                        <div class="flex justify-between items-center">
                            <span class="text-primary-100 text-sm">Status Unit</span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $hotel->status }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-100 text-sm">Tipe Kamar</span>
                            <span class="font-bold">{{ $hotel->tipe_kamar ?? 'Standard' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-dark-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Ketersediaan</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest inline-block py-1 px-2 rounded-full text-primary-500 bg-primary-500/10">
                                    {{ $hotel->kamar_tersedia }} Kamar Sisa
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold inline-block text-gray-500">
                                    {{ round(($hotel->kamar_tersedia / max(1, $hotel->kamar_total)) * 100) }}%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-100 dark:bg-dark-800">
                            <div style="width:{{ ($hotel->kamar_tersedia / max(1, $hotel->kamar_total)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-500 transition-all duration-500"></div>
                        </div>
                        <p class="text-xs text-gray-400">Total kapasitas: <strong>{{ $hotel->kamar_total }} unit kamar</strong></p>
                    </div>
                </div>

                <div class="bg-dark-900 dark:bg-dark-800 rounded-[2.5rem] p-8 text-white">
                    <h3 class="text-lg font-bold mb-6">Quick Tools</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex flex-col items-center justify-center p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-colors">
                            <i class="fas fa-calendar-check mb-2 text-primary-500"></i>
                            <span class="text-[10px] font-bold uppercase">Bookings</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-colors">
                            <i class="fas fa-chart-line mb-2 text-accent-500"></i>
                            <span class="text-[10px] font-bold uppercase">Analytics</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
