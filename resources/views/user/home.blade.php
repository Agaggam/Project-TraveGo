<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelGo - Temukan Petualangan Impianmu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0077B6',
                        'primary-light': '#48CAE4',
                        'primary-dark': '#023E8A',
                        accent: '#FFD60A',
                        'accent-light': '#FFE66D',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .nav-link { position: relative; color: #374151; font-weight: 500; transition: color 0.3s ease; }
        .nav-link:hover { color: #0077B6; }
        .nav-link.active { color: #0077B6; font-weight: 600; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.8s ease-out forwards; }
    </style>
</head>
<body class="font-sans">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-primary"><span>✈️</span> TravelGo</div>

            <ul class="hidden md:flex space-x-8 items-center">
                <li><span class="text-gray-600">Hai, <strong>{{ Auth::user()->name }}</strong>!</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden text-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <ul class="flex flex-col space-y-2 p-4">
                <li><span class="text-gray-600 block py-2">Hai, <strong>{{ Auth::user()->name }}</strong>!</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition text-left">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600"
                 alt="Travel Background"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-primary/80 via-primary/60 to-primary/80"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 text-center space-y-8 fade-in">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight">
                Temukan Petualangan<br>
                <span class="text-accent">Impianmu</span>
            </h1>
            <p class="text-xl md:text-2xl text-white/90 max-w-2xl mx-auto">
                Jelajahi dunia dengan paket wisata terbaik dari TravelGo
            </p>

            <div class="pt-4 max-w-2xl mx-auto">
                <form id="searchForm" class="flex gap-2">
                    <input type="text" id="searchInput" placeholder="Cari destinasi impianmu..."
                           class="flex-1 px-6 py-4 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-accent">
                    <button type="submit" class="bg-accent hover:bg-accent-light text-gray-800 px-8 py-4 rounded-lg font-semibold transition-all hover:scale-105">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Paket Wisata Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Paket Wisata Populer ✈️</h2>
                <p class="text-lg text-gray-600">Pilihan terbaik untuk liburan impianmu</p>
            </div>

            <div id="loading" class="text-center py-20">
                <div class="inline-block animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-primary"></div>
                <p class="mt-4 text-gray-600">Memuat paket wisata...</p>
            </div>

            <div id="paket-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 hidden"></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-4">🌍 TravelGo</h3>
            <p class="text-gray-300 mb-4">Agen perjalanan digital terpercaya</p>
            <p class="text-gray-400">© 2025 TravelGo. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Fetch Paket Wisata
        const API_URL = '/api/paket-wisata';

        async function fetchPakets(search = '') {
            const grid = document.getElementById('paket-grid');
            const loading = document.getElementById('loading');

            loading.classList.remove('hidden');
            grid.classList.add('hidden');
            grid.innerHTML = '';

            try {
                let url = search ? `${API_URL}?search=${search}` : `${API_URL}?limit=100`;
                const res = await fetch(url);
                const json = await res.json();

                loading.classList.add('hidden');

                const data = json.data.data ? json.data.data : json.data;

                if (!data || data.length === 0) {
                    grid.innerHTML = '<div class="col-span-3 text-center py-20"><p class="text-xl text-gray-600">Belum ada paket wisata tersedia.</p></div>';
                    grid.classList.remove('hidden');
                    return;
                }

                data.forEach(p => {
                    const img = p.gambar_url || 'https://via.placeholder.com/400x250?text=No+Image';
                    const formatRupiah = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

                    grid.innerHTML += `
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all hover:scale-105">
                            <img src="${img}" alt="${p.nama_paket}" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">${p.nama_paket}</h3>
                                <p class="text-primary mb-2">📍 ${p.lokasi}</p>
                                <p class="text-gray-600 mb-4">⏱️ ${p.durasi}</p>
                                <p class="text-gray-700 mb-4 line-clamp-3">${p.deskripsi}</p>
                                <div class="flex justify-between items-center border-t pt-4">
                                    <span class="text-2xl font-bold text-primary">${formatRupiah(p.harga)}</span>
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold">⭐ ${p.rating}</span>
                                </div>
                            </div>
                        </div>`;
                });

                grid.classList.remove('hidden');
            } catch (error) {
                loading.innerHTML = '<p class="text-red-500">Gagal memuat data.</p>';
            }
        }

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementByIALanjutkan('searchInput').value.trim();
fetchPakets(query);
});
    // Load initial data
    fetchPakets();
</script>
</body>
</html>
