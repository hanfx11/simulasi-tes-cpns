<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Persiapan CPNS 2026</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-gray-950 antialiased">
        <div class="min-h-screen">
            <header class="border-b border-gray-200 bg-white/95">
                <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8" aria-label="Navigasi utama">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-indigo-700 text-sm font-bold text-white">CP</span>
                        <span class="flex flex-col leading-tight">
                            <span class="text-sm font-bold text-gray-950">Persiapan CPNS 2026</span>
                            <span class="text-xs font-medium text-gray-500">Sistem latihan SKD terpadu</span>
                        </span>
                    </a>

                    <div class="hidden items-center gap-8 text-sm font-semibold text-gray-600 md:flex">
                        <a href="#fitur" class="hover:text-indigo-700">Fitur</a>
                        <a href="#alur" class="hover:text-indigo-700">Alur Belajar</a>
                        <a href="#materi" class="hover:text-indigo-700">Materi</a>
                        <a href="#keunggulan" class="hover:text-indigo-700">Keunggulan</a>
                    </div>

                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-md bg-indigo-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-800">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden rounded-md px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 sm:inline-flex">Masuk</a>
                            <a href="{{ route('register') }}" class="rounded-md bg-indigo-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-800">Daftar</a>
                        @endauth
                    </div>
                </nav>
            </header>

            <main>
                <section class="relative overflow-hidden border-b border-gray-200 bg-gray-50">
                    <div class="mx-auto grid max-w-7xl gap-12 px-4 py-14 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-8 lg:py-20">
                        <div class="flex flex-col justify-center">
                            <div class="mb-6 inline-flex w-fit items-center gap-2 rounded-md border border-indigo-100 bg-white px-3 py-2 text-sm font-semibold text-indigo-800 shadow-sm">
                                Platform belajar, latihan, dan simulasi CAT SKD
                            </div>

                            <h1 class="max-w-3xl text-4xl font-extrabold leading-tight text-gray-950 sm:text-5xl">
                                Sistem persiapan CPNS yang rapi untuk belajar serius, terukur, dan konsisten.
                            </h1>

                            <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                                Persiapan CPNS 2026 membantu peserta mempelajari TWK, TIU, dan TKP melalui modul terstruktur, bank soal original, simulasi ujian berbasis waktu, serta hasil evaluasi yang mudah dibaca.
                            </p>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-md bg-indigo-700 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-800">Buka Dashboard</a>
                                @else
                                    <a href="{{ route('register') }}" class="inline-flex justify-center rounded-md bg-indigo-700 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-800">Mulai Belajar</a>
                                    <a href="{{ route('login') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-5 py-3 text-sm font-bold text-gray-800 shadow-sm hover:bg-gray-50">Masuk ke Akun</a>
                                @endauth
                            </div>

                            <div class="mt-10 grid gap-3 border-t border-gray-200 pt-6 sm:grid-cols-3">
                                <div class="rounded-md border border-gray-200 bg-white p-4">
                                    <p class="text-sm font-bold text-gray-950">Modul terarah</p>
                                    <p class="mt-1 text-sm leading-6 text-gray-600">Materi disusun rapi dari konsep sampai checklist.</p>
                                </div>
                                <div class="rounded-md border border-gray-200 bg-white p-4">
                                    <p class="text-sm font-bold text-gray-950">Latihan original</p>
                                    <p class="mt-1 text-sm leading-6 text-gray-600">Soal dibuat untuk melatih pola berpikir SKD.</p>
                                </div>
                                <div class="rounded-md border border-gray-200 bg-white p-4">
                                    <p class="text-sm font-bold text-gray-950">Evaluasi belajar</p>
                                    <p class="mt-1 text-sm leading-6 text-gray-600">Hasil latihan membantu menentukan fokus berikutnya.</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-2xl">
                                <img
                                    src="{{ asset('images/hero-pns.png') }}"
                                    alt="Ilustrasi aparatur sipil negara profesional untuk persiapan CPNS"
                                    class="aspect-[4/3] w-full object-cover object-center"
                                >
                            </div>

                            <div class="mx-auto -mt-10 max-w-md rounded-lg border border-gray-200 bg-white p-5 shadow-xl lg:absolute lg:bottom-8 lg:left-8 lg:mx-0 lg:mt-0">
                                <p class="text-sm font-bold text-gray-950">Belajar dengan standar kerja aparatur</p>
                                <p class="mt-2 text-sm leading-6 text-gray-600">Materi dan latihan diarahkan pada ketelitian, integritas, pelayanan publik, serta kemampuan mengambil keputusan.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="fitur" class="bg-white py-16 sm:py-20">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="max-w-3xl">
                            <p class="text-sm font-bold uppercase text-indigo-700">Fitur Utama</p>
                            <h2 class="mt-3 text-3xl font-extrabold text-gray-950">Semua kebutuhan latihan SKD dalam satu sistem.</h2>
                            <p class="mt-4 text-base leading-7 text-gray-600">Dibuat untuk membantu peserta belajar dengan jalur yang jelas: baca materi, latihan soal, simulasi, lalu evaluasi hasil.</p>
                        </div>

                        <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                            @foreach ([
                                ['title' => 'Modul Belajar', 'body' => 'Materi TWK, TIU, dan TKP disusun dengan heading, isi, latihan, checklist, dan rujukan yang jelas.'],
                                ['title' => 'Bank Soal', 'body' => 'Soal latihan original dengan pembahasan agar peserta memahami alasan jawaban, bukan hanya menghafal opsi.'],
                                ['title' => 'Simulasi CAT', 'body' => 'Paket ujian berbasis durasi dengan navigasi nomor, status ragu-ragu, dan submit hasil ujian.'],
                                ['title' => 'Evaluasi Nilai', 'body' => 'Hasil latihan menampilkan skor TWK, TIU, TKP, status passing, dan rekomendasi area belajar.'],
                            ] as $feature)
                                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                                    <div class="mb-5 h-1.5 w-12 rounded-full bg-indigo-700"></div>
                                    <h3 class="text-lg font-bold text-gray-950">{{ $feature['title'] }}</h3>
                                    <p class="mt-3 text-sm leading-7 text-gray-600">{{ $feature['body'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section id="alur" class="border-y border-gray-200 bg-gray-50 py-16 sm:py-20">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
                            <div>
                                <p class="text-sm font-bold uppercase text-indigo-700">Alur Belajar</p>
                                <h2 class="mt-3 text-3xl font-extrabold text-gray-950">Dirancang untuk rutinitas belajar yang bisa diulang.</h2>
                                <p class="mt-4 text-base leading-7 text-gray-600">Sistem ini tidak berhenti pada halaman soal. Peserta diarahkan untuk membaca materi, mengukur kemampuan, memperbaiki kelemahan, dan mengulang latihan.</p>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ([
                                    ['step' => '01', 'title' => 'Pelajari Modul', 'body' => 'Mulai dari konsep inti, istilah kunci, tips menjawab, dan latihan singkat.'],
                                    ['step' => '02', 'title' => 'Kerjakan Bank Soal', 'body' => 'Uji pemahaman per kategori agar kelemahan tiap materi lebih terlihat.'],
                                    ['step' => '03', 'title' => 'Ikuti Simulasi', 'body' => 'Biasakan ritme pengerjaan dengan durasi dan jumlah soal yang menantang.'],
                                    ['step' => '04', 'title' => 'Evaluasi Hasil', 'body' => 'Gunakan skor dan pembahasan sebagai dasar menentukan sesi belajar berikutnya.'],
                                ] as $item)
                                    <div class="rounded-lg border border-gray-200 bg-white p-6">
                                        <span class="text-sm font-extrabold text-indigo-700">{{ $item['step'] }}</span>
                                        <h3 class="mt-3 text-lg font-bold text-gray-950">{{ $item['title'] }}</h3>
                                        <p class="mt-2 text-sm leading-7 text-gray-600">{{ $item['body'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <section id="materi" class="bg-white py-16 sm:py-20">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="max-w-3xl">
                            <p class="text-sm font-bold uppercase text-indigo-700">Cakupan Materi</p>
                            <h2 class="mt-3 text-3xl font-extrabold text-gray-950">Fokus pada tiga komponen utama SKD.</h2>
                        </div>

                        <div class="mt-10 grid gap-5 lg:grid-cols-3">
                            <div class="rounded-lg border border-gray-200 p-7">
                                <p class="text-sm font-bold text-indigo-700">TWK</p>
                                <h3 class="mt-2 text-xl font-extrabold text-gray-950">Tes Wawasan Kebangsaan</h3>
                                <p class="mt-4 text-sm leading-7 text-gray-600">Pancasila, UUD 1945, nasionalisme, NKRI, Bhinneka Tunggal Ika, integritas, bela negara, dan sejarah perjuangan bangsa.</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 p-7">
                                <p class="text-sm font-bold text-cyan-700">TIU</p>
                                <h3 class="mt-2 text-xl font-extrabold text-gray-950">Tes Intelegensia Umum</h3>
                                <p class="mt-4 text-sm leading-7 text-gray-600">Sinonim, antonim, analogi verbal, silogisme, deret angka, aritmetika, perbandingan, dan penalaran analitis.</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 p-7">
                                <p class="text-sm font-bold text-emerald-700">TKP</p>
                                <h3 class="mt-2 text-xl font-extrabold text-gray-950">Tes Karakteristik Pribadi</h3>
                                <p class="mt-4 text-sm leading-7 text-gray-600">Pelayanan publik, profesionalisme, integritas, kerja sama, adaptasi, pengendalian diri, teknologi informasi, dan pengambilan keputusan.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="keunggulan" class="bg-gray-950 py-16 text-white sm:py-20">
                    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
                        <div>
                            <p class="text-sm font-bold uppercase text-indigo-200">Keunggulan Sistem</p>
                            <h2 class="mt-3 text-3xl font-extrabold">Corporate-ready untuk pengelolaan latihan yang lebih tertib.</h2>
                            <p class="mt-4 text-base leading-7 text-gray-300">Cocok dipakai sebagai portal belajar internal, kelas persiapan, komunitas belajar, atau platform latihan mandiri.</p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach ([
                                'Konten latihan original dan tidak mengklaim sebagai bocoran soal resmi.',
                                'Struktur materi rapi sehingga mudah dipahami dari heading sampai rujukan.',
                                'Dashboard membantu peserta melihat progres dan rekomendasi belajar.',
                                'Simulasi berbasis waktu melatih strategi pengerjaan ujian.',
                                'Pembahasan soal membantu memperbaiki pola pikir saat menjawab.',
                                'Admin dapat mengelola data melalui panel yang sudah tersedia.',
                            ] as $benefit)
                                <div class="rounded-lg border border-white/10 bg-white/5 p-5">
                                    <p class="text-sm leading-7 text-gray-200">{{ $benefit }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="bg-white py-14">
                    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                        <div>
                            <h2 class="text-2xl font-extrabold text-gray-950">Siap mulai latihan SKD dengan sistem yang lebih tertata?</h2>
                            <p class="mt-2 text-sm leading-6 text-gray-600">Masuk ke dashboard untuk mengakses modul, bank soal, simulasi, dan hasil evaluasi.</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-md bg-indigo-700 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-800">Buka Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex justify-center rounded-md bg-indigo-700 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-800">Daftar Sekarang</a>
                                <a href="{{ route('login') }}" class="inline-flex justify-center rounded-md border border-gray-300 px-5 py-3 text-sm font-bold text-gray-800 hover:bg-gray-50">Masuk</a>
                            @endauth
                        </div>
                    </div>
                </section>
            </main>

            <footer class="border-t border-gray-200 bg-gray-50">
                <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-8 text-sm text-gray-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                    <div>
                        <p>&copy; {{ date('Y') }} Persiapan CPNS 2026. Sistem latihan SKD terpadu.</p>
                        <p class="mt-1">Materi belajar original, bukan soal asli atau bocoran seleksi resmi.</p>
                    </div>
                    <p>
                        Created by
                        <a href="https://github.com/hanfx11" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 font-semibold text-gray-800 underline decoration-gray-300 underline-offset-4 hover:text-indigo-700 hover:decoration-indigo-500">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.867-.014-1.702-2.782.605-3.369-1.343-3.369-1.343-.455-1.158-1.11-1.466-1.11-1.466-.908-.621.069-.608.069-.608 1.004.071 1.532 1.033 1.532 1.033.892 1.531 2.341 1.089 2.91.833.091-.647.349-1.089.635-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.094.39-1.988 1.03-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.56 9.56 0 0 1 12 6.871a9.56 9.56 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.641.7 1.029 1.594 1.029 2.688 0 3.848-2.338 4.695-4.566 4.944.359.31.678.92.678 1.855 0 1.339-.012 2.419-.012 2.748 0 .267.18.578.688.48C19.138 20.202 22 16.448 22 12.021 22 6.484 17.523 2 12 2Z" clip-rule="evenodd" />
                            </svg>
                            Hanif
                        </a>
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>
