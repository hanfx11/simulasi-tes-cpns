<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-semibold text-gray-900">Modul Belajar</h1>
            <p class="text-sm text-gray-600">Materi ringkas TWK, TIU, dan TKP</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <form method="GET" class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="flex flex-col gap-3 md:flex-row md:items-end">
                    <label class="block md:w-96">
                        <span class="text-sm font-medium text-gray-700">Kategori</span>
                        <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->code }} - {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Filter</button>
                    <a href="{{ route('modules.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
                </div>
            </form>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($modules as $module)
                    <a href="{{ route('modules.show', $module) }}" class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200 hover:ring-indigo-300">
                        <div class="inline-flex rounded bg-indigo-50 px-2 py-1 text-xs font-semibold uppercase text-indigo-700">{{ $module->category->code }}</div>
                        <h2 class="mt-2 text-base font-semibold text-gray-900">{{ $module->title }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ $module->subcategory?->name }}</p>
                        <p class="mt-3 line-clamp-4 text-sm leading-6 text-gray-600">{{ trim(strip_tags($module->content)) }}</p>
                        <span class="mt-4 inline-flex text-sm font-semibold text-indigo-700">Buka modul</span>
                    </a>
                @empty
                    <div class="rounded-lg bg-white p-8 text-center text-sm text-gray-500 shadow-sm ring-1 ring-gray-200 md:col-span-2 lg:col-span-3">
                        Belum ada modul untuk filter ini.
                    </div>
                @endforelse
            </div>

            {{ $modules->links() }}
        </div>
    </div>
</x-app-layout>
