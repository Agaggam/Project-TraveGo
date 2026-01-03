@extends('layouts.admin')

@section('title', 'Detail Tiket - ' . $ticket->kode_transportasi)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.tickets.index') }}" class="w-12 h-12 bg-white dark:bg-dark-900 rounded-2xl flex items-center justify-center shadow-sm border border-gray-100 dark:border-dark-800 text-gray-400 hover:text-primary-500 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ $ticket->nama_transportasi }}</h1>
                    <div class="flex items-center mt-1">
                        <span class="px-3 py-1 bg-accent-500/10 text-accent-500 text-[10px] font-black uppercase tracking-widest rounded-full mr-3">{{ $ticket->kode_transportasi }}</span>
                        <span class="text-sm text-gray-500 font-bold uppercase tracking-tighter">{{ $ticket->jenis_transportasi }} • {{ $ticket->kelas }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.tickets.edit', $ticket) }}" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-2xl font-bold transition-all duration-300 shadow-lg">
                    <i class="fas fa-edit mr-2"></i>Edit Tiket
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Flight Route Visualization -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-dark-900 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-dark-800 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-accent-500/5 rounded-full -mr-32 -mt-32"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-10">Rute Perjalanan</h3>
                        
                        <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-4">
                            <div class="text-center md:text-left flex-1">
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Keberangkatan</p>
                                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $ticket->asal }}</h4>
                                <p class="text-xl font-bold text-accent-500 mt-1">{{ $ticket->waktu_berangkat->format('H:i') }}</p>
                                <p class="text-sm text-gray-500 mt-1 font-medium">{{ $ticket->waktu_berangkat->format('d M Y') }}</p>
                            </div>

                            <div class="flex flex-col items-center px-8 flex-1">
                                <p class="text-[10px] font-bold text-gray-400 mb-2 uppercase">{{ floor($ticket->durasi_menit / 60) }}j {{ $ticket->durasi_menit % 60 }}m</p>
                                <div class="w-full flex items-center">
                                    <div class="w-2 h-2 rounded-full border-2 border-accent-500"></div>
                                    <div class="flex-1 h-0.5 border-t-2 border-dashed border-gray-200 dark:border-dark-700 relative">
                                        <i class="fas fa-{{ $ticket->jenis_transportasi == 'pesawat' ? 'plane' : ($ticket->jenis_transportasi == 'kereta' ? 'train' : 'bus') }} absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-accent-500 bg-white dark:bg-dark-900 px-2"></i>
                                    </div>
                                    <div class="w-2 h-2 rounded-full bg-accent-500"></div>
                                </div>
                                <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-widest">Langsung</p>
                            </div>

                            <div class="text-center md:text-right flex-1">
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Kedatangan</p>
                                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $ticket->tujuan }}</h4>
                                <p class="text-xl font-bold text-accent-500 mt-1">{{ $ticket->waktu_tiba->format('H:i') }}</p>
                                <p class="text-sm text-gray-500 mt-1 font-medium">{{ $ticket->waktu_tiba->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-900 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-dark-800">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Fasilitas & Layanan</h3>
                    <div class="flex flex-wrap gap-3">
                        @php $facilityList = explode(',', $ticket->fasilitas); @endphp
                        @forelse($facilityList as $fac)
                        <span class="px-5 py-3 bg-gray-50 dark:bg-dark-800 text-gray-700 dark:text-dark-200 rounded-2xl text-sm font-bold flex items-center">
                            <i class="fas fa-check-circle text-accent-500 mr-2"></i> {{ trim($fac) }}
                        </span>
                        @empty
                        <span class="text-gray-400 italic">Tidak ada informasi fasilitas</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="space-y-8">
                <div class="bg-dark-900 rounded-[2.5rem] p-8 text-white shadow-xl">
                    <p class="text-gray-400 font-medium uppercase tracking-widest text-[10px] mb-2">Harga Tiket</p>
                    <div class="flex items-center mb-8">
                        <span class="text-4xl font-black text-primary-500">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                        <span class="ml-2 text-gray-500">/ pax</span>
                    </div>
                    
                    <div class="space-y-4 pt-6 border-t border-white/10">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Status</span>
                            <span class="px-3 py-1 {{ $ticket->aktif ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }} rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ $ticket->aktif ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">Total Seats</span>
                            <span class="font-bold">{{ $ticket->kapasitas }} Kursi</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-dark-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Okupansi Kursi</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest inline-block py-1 px-2 rounded-full text-accent-500 bg-accent-500/10">
                                    {{ $ticket->tersedia }} Tersedia
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold inline-block text-gray-500">
                                    {{ round(($ticket->tersedia / max(1, $ticket->kapasitas)) * 100) }}%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-100 dark:bg-dark-800">
                            <div style="width:{{ ($ticket->tersedia / max(1, $ticket->kapasitas)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-accent-500 transition-all duration-500"></div>
                        </div>
                        <p class="text-xs text-gray-400">Okupansi saat ini: <strong>{{ $ticket->kapasitas - $ticket->tersedia }} Terisi</strong></p>
                    </div>
                </div>

                <div class="bg-accent-500 rounded-[2.5rem] p-8 text-white shadow-xl shadow-accent-500/20">
                    <h3 class="text-lg font-bold mb-6 italic">Travel Insights</h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-white/10 rounded-2xl flex items-center">
                            <i class="fas fa-fire-alt mr-4 text-xl"></i>
                            <div>
                                <p class="text-[10px] font-bold uppercase py-0.5">Demand</p>
                                <p class="text-sm font-medium">Trending Route</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
