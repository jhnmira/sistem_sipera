<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIPERA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white">
    <div class="flex min-h-screen">

        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative flex-col justify-between p-12 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">SIPERA</h1>
            </div>

            <div class="relative z-10 mb-10">
                <h2 class="text-4xl font-bold mb-4">SELAMAT DATANG DI SIPERA!<br> <br> Manajemen Aset Terintegrasi</h2>
                <p class="text-slate-400 text-lg leading-relaxed">
                    Sistem Pencatatan Perawatan Alat Elektronik membantu Anda memantau kondisi, jadwal servis, dan riwayat perbaikan aset perusahaan secara real-time.
                </p>
            </div>

            <div class="relative z-10 text-sm text-slate-500">
                &copy; {{ date('Y') }} SIPERA - Badan Pusat Statistik Kota Yogyakarta.
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

                <div class="text-center mb-8 px-4">
                    <img src="{{ asset('images/logo_bps.png') }}"alt="Logo BPS"class="mx-auto mb-4 h-16 sm:h-20 md:h-24 w-auto">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">BPS Kota Yogyakarta</h2>
                    <p class="text-gray-500 mt-2 text-sm sm:text-base">Silakan masuk untuk mengakses dashboard.<br> Hanya akun admin yang dapat login.</p></div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input id="username" type="text" name="username" :value="old('username')" required autofocus
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition duration-200 outline-none"
                            placeholder="Masukkan username">
                        @error('username')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition duration-200 outline-none"
                            placeholder="••••••••">
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" onclick="togglePassword()" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Tampilkan Password</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                        Masuk ke Sistem
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    function togglePassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
</html>
