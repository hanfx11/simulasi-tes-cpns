<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-semibold text-gray-900">Detail Soal</h1>
            <p class="text-sm text-gray-600">{{ $question->category->code }} - {{ $question->subcategory->name }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('questions.index') }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">Kembali ke Bank Soal</a>

            <article class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase">
                    <span class="rounded bg-indigo-50 px-2 py-1 text-indigo-700">{{ $question->category->code }}</span>
                    <span class="rounded bg-blue-50 px-2 py-1 text-blue-700">Soal {{ $questionNumber }}</span>
                    <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $question->subcategory->name }}</span>
                    <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $question->difficulty }}</span>
                    <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $question->score_type }}</span>
                </div>

                <div class="mt-5 whitespace-pre-line text-base leading-7 text-gray-900">{{ $question->question_text }}</div>

                <div class="mt-6 space-y-3">
                    @foreach ($question->options as $option)
                        @php
                            $isBest = $question->score_type === 'binary' ? $option->is_correct : $option->score === 5;
                        @endphp
                        <div class="rounded-lg border p-4 {{ $isBest ? 'border-green-300 bg-green-50' : 'border-gray-200' }}">
                            <div class="flex gap-3">
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">{{ $option->option_label }}</div>
                                <div>
                                    <div class="text-sm text-gray-900">{{ $option->option_text }}</div>
                                    @if ($question->score_type === 'weighted')
                                        <div class="mt-1 text-xs font-medium text-gray-500">Skor TKP: {{ $option->score }}</div>
                                    @elseif ($option->is_correct)
                                        <div class="mt-1 text-xs font-medium text-green-700">Jawaban benar</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 rounded-lg border border-indigo-100 bg-indigo-50 p-4">
                    <h2 class="text-sm font-semibold text-indigo-950">Pembahasan</h2>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-indigo-950">{{ $question->explanation }}</p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
