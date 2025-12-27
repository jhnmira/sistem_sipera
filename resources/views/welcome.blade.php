<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIPERA - Sistem Perawatan Alat</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 text-gray-800">

        <nav class="w-full py-6 px-6 md:px-12 flex justify-between items-center max-w-7xl mx-auto">
            <div class="text-2xl font-extrabold tracking-tighter text-indigo-900">
                SIPERA<span class="text-indigo-600">.</span>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-6 md:px-12 py-16 md:py-24 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="space-y-8">
                <div class="inline-block bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-2">
                    Internal System v1.0
                </div>
                <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight">
                    Rawat Aset,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Jaga Kinerja.</span>
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed max-w-lg">
                    Sistem Pencatatan Perawatan Alat (SIPERA) memudahkan administrasi inventaris, penjadwalan servis otomatis, dan pelacakan riwayat kondisi alat elektronik perusahaan.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center justify-center px-8 py-4 text-lg font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-xl shadow-indigo-200">
                            Masuk Sekarang
                        </a>
                        <a href="{{ asset('Panduan SIPERA.docx') }}" download class="flex items-center justify-center px-8 py-4 text-lg font-bold rounded-xl text-white bg-green-600 hover:bg-green-700 transition shadow-xl shadow-green-200">
                            Download Panduan
                        </a>
                    @endguest
                </div>
            </div>

            <div class="relative">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob"></div>
                <div class="absolute top-0 right-20 -mt-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-2000"></div>

                <div class="relative grid gap-6 grid-cols-2">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center text-center transform hover:-translate-y-1 transition">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800">Pendataan Aset</h3>
                        <p class="text-sm text-gray-500 mt-2">Database lengkap NUP & Lokasi.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center text-center mt-12 transform hover:-translate-y-1 transition">
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800">Jadwal Servis</h3>
                        <p class="text-sm text-gray-500 mt-2">Reminder otomatis berbasis interval.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center text-center transform hover:-translate-y-1 transition">
                        <div class="p-3 bg-orange-50 text-orange-600 rounded-lg mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800">Export Excel</h3>
                        <p class="text-sm text-gray-500 mt-2">Laporan mudah dalam sekali klik.</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="text-center py-8 text-gray-400 text-sm">
            &copy; {{ date('Y') }} SIPERA - Badan Pusat Statistik Kota Yogyakarta.
        </footer>
    </body>
</html>
