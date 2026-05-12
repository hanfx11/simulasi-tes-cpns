<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-semibold text-gray-900">Bank Soal</h1>
            <p class="text-sm text-gray-600">Latihan original TWK, TIU, dan TKP</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-lg border border-indigo-100 bg-indigo-50 p-4 text-sm text-indigo-950">
                Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi.
            </div>

            <form method="GET" class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="grid gap-4 md:grid-cols-4">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Kategori</span>
                        <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">Semua</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->code }} - {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Subkategori</span>
                        <select name="subcategory_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">Semua</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @selected($selectedSubcategoryId === $subcategory->id)>{{ $subcategory->category->code }} - {{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Kesulitan</span>
                        <select name="difficulty" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">Semua</option>
                            @foreach (['easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard'] as $value => $label)
                                <option value="{{ $value }}" @selected($selectedDifficulty === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="flex items-end gap-2">
                        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Filter</button>
                        <a href="{{ route('questions.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
                    </div>
                </div>
            </form>

            <div class="grid gap-4">
                @forelse ($questions as $question)
                    <a href="{{ route('questions.show', $question) }}" class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200 hover:ring-indigo-300">
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase">
                            <span class="rounded bg-indigo-50 px-2 py-1 text-indigo-700">{{ $question->category->code }}</span>
                            <span class="rounded bg-blue-50 px-2 py-1 text-blue-700">Soal {{ $questions->firstItem() + $loop->index }}</span>
                            <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $question->subcategory->name }}</span>
                            <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $question->difficulty }}</span>
                            <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $question->score_type }}</span>
                        </div>
                        <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-800">{{ $question->question_text }}</p>
                    </a>
                @empty
                    <div class="rounded-lg bg-white p-8 text-center text-sm text-gray-500 shadow-sm ring-1 ring-gray-200">
                        Belum ada soal untuk filter ini.
                    </div>
                @endforelse
            </div>

            {{ $questions->links() }}
        </div>
    </div>
</x-app-layout>
