<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - TravelGo</title>
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
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-primary mb-2"><span>✈️</span> TravelGo</h1>
            <p class="text-gray-600">Mulai petualangan Anda!</p>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Akun Baru</h2>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-blue-100 focus:border-primary transition outline-none"
                           placeholder="John Doe">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-blue-100 focus:border-primary transition outline-none"
                           placeholder="nama@email.com">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-blue-100 focus:border-primary transition outline-none"
                           placeholder="Minimal 6 karakter">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-blue-100 focus:border-primary transition outline-none"
                           placeholder="Ulangi password">
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-primary to-primary-dark text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 active:scale-95">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>

        <p class="text-center text-gray-500 text-sm mt-6">
            © 2025 TravelGo. All rights reserved.
        </p>
    </div>
</body>
</html>
