<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelGo Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hidden-section { display: none !important; }
        .fade-in { animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-blue-100 selection:text-blue-900">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" onclick="showHome()" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-2 hover:opacity-80 transition">
                <span>✈️</span> TravelGo API
            </a>
            <button onclick="showForm('create')" class="bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-6 py-2.5 rounded-full font-semibold shadow-lg shadow-orange-200 hover:shadow-orange-300 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Paket
            </button>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10 min-h-screen">

        <section id="view-home" class="fade-in">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Jelajahi Paket Wisata</h1>
                    <p class="text-gray-500 mt-1">Kelola destinasi impian dengan mudah</p>
                </div>

                <div class="relative w-full md:w-96 group">
                    <input type="text" id="search-input"
                           placeholder="Cari destinasi atau lokasi..."
                           class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-200 bg-white shadow-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none text-sm group-hover:shadow-md"
                           onkeyup="if(event.key === 'Enter') fetchPakets(this.value)">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 transition group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div id="loading-home" class="text-center py-32 hidden">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-blue-600 mb-4"></div>
                <p class="text-gray-500 font-medium animate-pulse">Sedang memuat data...</p>
            </div>

            <div id="paket-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 pb-20"></div>
        </section>

        <section id="view-form" class="hidden-section fade-in max-w-3xl mx-auto">
            <button onclick="showHome()" class="group flex items-center gap-2 text-gray-500 mb-6 hover:text-blue-600 transition font-medium">
                <span class="p-2 rounded-full bg-white shadow-sm group-hover:shadow-md transition">←</span> Kembali
            </button>

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-100 border border-gray-50 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 id="form-title" class="text-2xl font-bold text-gray-800">✨ Form Data</h2>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi informasi paket wisata di bawah ini</p>
                </div>

                <form id="dataForm" class="p-8 space-y-6">
                    <input type="hidden" id="edit-id" name="id">

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-blue-600 transition">Nama Paket</label>
                        <input type="text" name="nama_paket" id="inp-nama" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none placeholder:text-gray-400"
                               placeholder="Contoh: Eksotis Bali 3H2M">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-semibold text-sm">Rp</span>
                                <input type="number" name="harga" id="inp-harga" required
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none"
                                       placeholder="0">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                            <input type="text" name="durasi" id="inp-durasi" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none"
                                   placeholder="Contoh: 3 Hari 2 Malam">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400">📍</span>
                                <input type="text" name="lokasi" id="inp-lokasi" required
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none"
                                       placeholder="Contoh: Bali">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating (0-5)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400">⭐</span>
                                <input type="number" name="rating" id="inp-rating" step="0.1" max="5"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none"
                                       placeholder="4.5">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">URL Gambar Sampul</label>
                        <input type="url" name="gambar_url" id="inp-gambar"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none text-sm text-blue-600"
                               placeholder="https://example.com/image.jpg">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Lengkap</label>
                        <textarea name="deskripsi" id="inp-deskripsi" rows="4" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition outline-none"
                                  placeholder="Jelaskan keunggulan paket ini..."></textarea>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-gray-50">
                        <button type="button" onclick="showHome()" class="flex-1 px-6 py-3.5 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition active:scale-95">
                            Batal
                        </button>
                        <button type="submit" class="flex-[2] px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 transition active:scale-95 flex justify-center items-center gap-2">
                            <span>💾</span> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section id="view-detail" class="hidden-section fade-in max-w-5xl mx-auto">
            <button onclick="showHome()" class="group flex items-center gap-2 text-gray-500 mb-6 hover:text-blue-600 transition font-medium">
                <span class="p-2 rounded-full bg-white shadow-sm group-hover:shadow-md transition">←</span> Kembali ke Daftar
            </button>

            <div id="loading-detail" class="text-center py-32 hidden">
                <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-t-blue-600"></div>
            </div>

            <div id="detail-content" class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200 overflow-hidden hidden">
                <div class="relative h-[400px] group">
                    <img id="d-img" src="" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 w-full p-8 md:p-12 text-white">
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                            <div>
                                <span id="d-lokasi" class="bg-white/20 backdrop-blur-md border border-white/30 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block shadow-sm">
                                    📍 Lokasi
                                </span>
                                <h1 id="d-nama" class="text-4xl md:text-6xl font-bold mb-3 leading-tight drop-shadow-lg">Nama Paket</h1>
                                <div class="flex items-center gap-6 text-sm md:text-base font-medium text-gray-200">
                                    <span id="d-durasi" class="flex items-center gap-2 bg-black/30 px-3 py-1 rounded-lg backdrop-blur-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Durasi
                                    </span>
                                    <span id="d-rating" class="flex items-center gap-2 bg-yellow-500/20 px-3 py-1 rounded-lg backdrop-blur-sm text-yellow-300 border border-yellow-500/30">
                                        ⭐ Rating
                                    </span>
                                </div>
                            </div>
                            <div class="text-left md:text-right bg-white/10 p-4 rounded-2xl backdrop-blur-md border border-white/10">
                                <p class="text-gray-300 text-xs uppercase tracking-widest mb-1">Harga Mulai</p>
                                <p id="d-harga-head" class="text-3xl md:text-4xl font-bold text-white drop-shadow-md">Rp 0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-2 rounded-lg">📄</span> Deskripsi Paket
                        </h3>
                        <p id="d-deskripsi" class="text-gray-600 leading-relaxed text-lg whitespace-pre-line text-justify"></p>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100">
                            <p class="text-gray-500 text-sm mb-2">Total Pembayaran</p>
                            <p id="d-harga" class="text-4xl font-bold text-blue-600 mb-8">Rp 0</p>

                            <button onclick="Swal.fire('Berhasil', 'Fitur booking simulasi sukses!', 'success')" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition transform hover:-translate-y-1 active:scale-95 mb-4">
                                Booking Sekarang 🚀
                            </button>
                            <p class="text-xs text-center text-gray-400">Jaminan harga terbaik & aman.</p>
                        </div>

                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                            <h4 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wider">Admin Actions</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <button id="btn-edit" class="flex items-center justify-center gap-2 bg-yellow-50 text-yellow-700 font-bold py-3 rounded-xl hover:bg-yellow-100 transition border border-yellow-100">
                                    <span>✏️</span> Edit
                                </button>
                                <button id="btn-hapus" class="flex items-center justify-center gap-2 bg-red-50 text-red-600 font-bold py-3 rounded-xl hover:bg-red-100 transition border border-red-100">
                                    <span>🗑️</span> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script>
        const API_URL = '/api/paket-wisata';

        // --- NAVIGATION ---
        function hideAll() {
            ['view-home', 'view-form', 'view-detail'].forEach(id => document.getElementById(id).classList.add('hidden-section'));
        }

        function showHome() {
            hideAll();
            document.getElementById('view-home').classList.remove('hidden-section');
            fetchPakets();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // --- FETCH DATA ---
        async function fetchPakets(search = '') {
            const grid = document.getElementById('paket-grid');
            const loading = document.getElementById('loading-home');

            loading.classList.remove('hidden');
            grid.innerHTML = '';

            try {
                let url = search ? `${API_URL}?search=${search}` : `${API_URL}?limit=100`; // Default limit 100
                const res = await fetch(url);
                const json = await res.json();

                loading.classList.add('hidden');

                const data = json.data.data ? json.data.data : json.data;

                if (!data || data.length === 0) {
                    grid.innerHTML = `
                        <div class="col-span-3 text-center py-20 opacity-50">
                            <div class="text-6xl mb-4">📭</div>
                            <p class="text-xl font-medium">Belum ada paket wisata.</p>
                            <button onclick="showForm('create')" class="text-blue-500 mt-2 underline">Buat baru sekarang</button>
                        </div>`;
                    return;
                }

                data.forEach(p => {
                    const img = p.gambar_url || 'https://via.placeholder.com/400x250?text=No+Image';
                    grid.innerHTML += `
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl hover:shadow-blue-100 border border-gray-100 overflow-hidden cursor-pointer group transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full" onclick="showDetail(${p.id})">
                            <div class="relative h-56 overflow-hidden">
                                <img src="${img}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                <span class="absolute top-4 right-4 bg-white/90 backdrop-blur text-gray-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                                    📍 ${p.lokasi}
                                </span>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="mb-4">
                                    <h3 class="font-bold text-xl text-gray-800 mb-2 line-clamp-1 group-hover:text-blue-600 transition">${p.nama_paket}</h3>
                                    <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                                        <span class="flex items-center gap-1 bg-gray-100 px-2 py-1 rounded-md">⏳ ${p.durasi}</span>
                                        <span class="flex items-center gap-1 bg-yellow-50 text-yellow-600 px-2 py-1 rounded-md">⭐ ${p.rating}</span>
                                    </div>
                                </div>
                                <div class="mt-auto flex justify-between items-end border-t border-gray-50 pt-4">
                                    <div>
                                        <p class="text-xs text-gray-400 mb-1">Mulai dari</p>
                                        <span class="text-xl font-bold text-blue-600">${formatRupiah(p.harga)}</span>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition transform group-hover:rotate-45">
                                        ↗
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
            } catch (error) {
                loading.innerHTML = '<p class="text-red-500">Gagal terhubung ke server.</p>';
            }
        }

        // --- FORM HANDLING ---
        async function showForm(mode, id = null) {
            hideAll();
            document.getElementById('view-form').classList.remove('hidden-section');
            document.getElementById('dataForm').reset();
            document.getElementById('edit-id').value = id || '';
            document.getElementById('form-title').innerHTML = mode === 'create' ? '✨ Tambah Paket Baru' : '✏️ Edit Paket Wisata';
            window.scrollTo({ top: 0, behavior: 'smooth' });

            if (mode === 'edit') {
                try {
                    const res = await fetch(`${API_URL}/${id}`);
                    const json = await res.json();
                    if(json.status === 'success'){
                        const d = json.data;
                        document.getElementById('inp-nama').value = d.nama_paket;
                        document.getElementById('inp-harga').value = d.harga;
                        document.getElementById('inp-durasi').value = d.durasi;
                        document.getElementById('inp-lokasi').value = d.lokasi;
                        document.getElementById('inp-rating').value = d.rating;
                        document.getElementById('inp-gambar').value = d.gambar_url;
                        document.getElementById('inp-deskripsi').value = d.deskripsi;
                    }
                } catch (e) { Swal.fire('Error', 'Gagal memuat data', 'error'); }
            }
        }

        document.getElementById('dataForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Menyimpan...';

            const id = document.getElementById('edit-id').value;
            const url = id ? `${API_URL}/${id}` : API_URL;
            const method = id ? 'PUT' : 'POST';

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            // Data Cleaning
            data.harga = parseFloat(data.harga);
            data.rating = data.rating ? parseFloat(data.rating) : 0;
            if (!data.gambar_url || data.gambar_url.trim() === "") data.gambar_url = null;

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                const json = await res.json();

                if (res.ok) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data telah disimpan dengan aman.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    showHome();
                } else {
                    let msg = '';
                    if (json.errors) { for (const k in json.errors) msg += `• ${json.errors[k]}<br>`; }
                    else { msg = json.message; }
                    Swal.fire({ icon: 'error', title: 'Ups, ada masalah!', html: msg });
                }
            } catch (e) {
                Swal.fire('Error', 'Kesalahan jaringan server.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });

        // --- DETAIL & DELETE ---
        async function showDetail(id) {
            hideAll();
            document.getElementById('view-detail').classList.remove('hidden-section');
            document.getElementById('loading-detail').classList.remove('hidden');
            document.getElementById('detail-content').classList.add('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });

            try {
                const res = await fetch(`${API_URL}/${id}`);
                const json = await res.json();

                if (json.status === 'success') {
                    const p = json.data;
                    const imgUrl = p.gambar_url || 'https://via.placeholder.com/800x400';

                    document.getElementById('d-img').src = imgUrl;
                    document.getElementById('d-nama').innerText = p.nama_paket;
                    document.getElementById('d-lokasi').innerHTML = `📍 ${p.lokasi}`;
                    document.getElementById('d-durasi').innerHTML = `<svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${p.durasi}`;
                    document.getElementById('d-rating').innerHTML = `⭐ ${p.rating}`;
                    document.getElementById('d-deskripsi').innerText = p.deskripsi;
                    document.getElementById('d-harga').innerText = formatRupiah(p.harga);
                    document.getElementById('d-harga-head').innerText = formatRupiah(p.harga);

                    document.getElementById('btn-edit').onclick = () => showForm('edit', p.id);
                    document.getElementById('btn-hapus').onclick = () => deletePaket(p.id);

                    document.getElementById('loading-detail').classList.add('hidden');
                    document.getElementById('detail-content').classList.remove('hidden');
                }
            } catch (e) { Swal.fire('Error', 'Gagal memuat detail', 'error'); }
        }

        async function deletePaket(id) {
            const result = await Swal.fire({
                title: 'Yakin hapus?',
                text: "Data ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
                await Swal.fire({ title: 'Terhapus!', text: 'Data berhasil dihapus.', icon: 'success', timer: 1500, showConfirmButton: false });
                showHome();
            }
        }

        function formatRupiah(n) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);
        }

        // Init
        fetchPakets();
    </script>
</body>
</html>
