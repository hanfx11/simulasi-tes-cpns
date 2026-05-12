<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-semibold text-gray-900">Dashboard Belajar</h1>
            <p class="text-sm text-gray-600">CAT CPNS Personal Trainer</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0 space-y-6">
                <div class="rounded-lg border border-indigo-100 bg-indigo-50 p-4 text-sm text-indigo-950">
                    Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi.
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                        <div class="text-sm text-gray-500">Bank Soal Aktif</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalQuestions) }}</div>
                    </div>
                    <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                        <div class="text-sm text-gray-500">Modul Belajar</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalModules) }}</div>
                    </div>
                    <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                        <div class="text-sm text-gray-500">Tryout Terakhir</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">
                            {{ $latestSession ? $latestSession->score_total : '-' }}
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200 lg:col-span-2">
                        <div class="flex items-center justify-between gap-4">
                            <h2 class="text-base font-semibold text-gray-900">Ringkasan Materi</h2>
                            <a href="{{ route('questions.index') }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">Lihat semua soal</a>
                        </div>
                        <div class="mt-4 divide-y divide-gray-100">
                            @foreach ($categoryStats as $category)
                                <div class="flex items-center justify-between py-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $category->code }}</div>
                                        <div class="text-sm text-gray-500">{{ $category->name }}</div>
                                    </div>
                                    <div class="text-right text-sm text-gray-600">
                                        <div>{{ number_format($category->questions_count) }} soal</div>
                                        <div>{{ number_format($category->learning_modules_count) }} modul</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                        <h2 class="text-base font-semibold text-gray-900">Mulai Cepat</h2>
                        <div class="mt-4 space-y-3">
                            @if ($fullPackage)
                                <form method="POST" action="{{ route('exams.start', $fullPackage) }}">
                                    @csrf
                                    <button class="block w-full rounded-md bg-green-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-green-700">Mulai Simulasi SKD</button>
                                </form>
                            @endif
                            <a href="{{ route('questions.index') }}" class="block rounded-md bg-indigo-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-indigo-700">Buka Bank Soal</a>
                            <a href="{{ route('modules.index') }}" class="block rounded-md border border-gray-300 px-4 py-3 text-center text-sm font-semibold text-gray-800 hover:bg-gray-50">Buka Modul Belajar</a>
                            @if (auth()->user()->isAdmin())
                                <a href="/admin" class="block rounded-md border border-gray-300 px-4 py-3 text-center text-sm font-semibold text-gray-800 hover:bg-gray-50">Buka Admin Panel</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-base font-semibold text-gray-900">Modul Rekomendasi Awal</h2>
                        <a href="{{ route('modules.index') }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">Lihat semua modul</a>
                    </div>
                    <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($recentModules as $module)
                            <a href="{{ route('modules.show', $module) }}" class="rounded-lg border border-gray-200 p-4 hover:border-indigo-300 hover:bg-indigo-50">
                                <div class="text-xs font-semibold uppercase text-indigo-700">{{ $module->category->code }}</div>
                                <div class="mt-1 font-semibold text-gray-900">{{ $module->title }}</div>
                                <div class="mt-1 text-sm text-gray-500">{{ $module->subcategory?->name }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
