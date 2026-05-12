<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-semibold text-gray-900">{{ $module->title }}</h1>
            <p class="text-sm text-gray-600">{{ $module->category->code }} - {{ $module->subcategory?->name }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('modules.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                Kembali ke Modul
            </a>

            <article class="module-content mt-6 rounded-lg bg-white px-5 py-6 shadow-sm ring-1 ring-gray-200 sm:px-8 sm:py-8">
                {!! $module->content !!}
            </article>

            <div class="mt-6 rounded-lg border border-indigo-100 bg-indigo-50 p-5 text-sm leading-6 text-indigo-950">
                Materi dan soal latihan di aplikasi ini adalah konten belajar original berbasis pola kompetensi SKD CPNS. Konten tidak berisi soal asli, bocoran, atau klaim sebagai dokumen resmi seleksi.
            </div>
        </div>
    </div>
</x-app-layout>
