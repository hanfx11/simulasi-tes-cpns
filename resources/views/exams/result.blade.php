<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-semibold text-gray-900">Hasil Ujian</h1>
            <p class="text-sm text-gray-600">{{ $session->examPackage?->title }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $session->score_total }}</div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="text-sm text-gray-500">TWK</div>
                    <div class="mt-2 text-3xl font-semibold {{ $session->passed_twk ? 'text-green-700' : 'text-red-700' }}">{{ $session->score_twk }}</div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="text-sm text-gray-500">TIU</div>
                    <div class="mt-2 text-3xl font-semibold {{ $session->passed_tiu ? 'text-green-700' : 'text-red-700' }}">{{ $session->score_tiu }}</div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="text-sm text-gray-500">TKP</div>
                    <div class="mt-2 text-3xl font-semibold {{ $session->passed_tkp ? 'text-green-700' : 'text-red-700' }}">{{ $session->score_tkp }}</div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <h2 class="text-base font-semibold text-gray-900">Status Passing Grade</h2>
                <div class="mt-3 text-lg font-semibold {{ $session->passed_total ? 'text-green-700' : 'text-red-700' }}">
                    {{ $session->passed_total ? 'Lulus Passing Grade' : 'Belum Lulus Passing Grade' }}
                </div>
                <div class="mt-4 grid gap-4 md:grid-cols-3 text-sm text-gray-700">
                    <div>TWK: benar {{ $summary['TWK']['correct'] }}, salah {{ $summary['TWK']['wrong'] }}, kosong {{ $summary['TWK']['empty'] }}</div>
                    <div>TIU: benar {{ $summary['TIU']['correct'] }}, salah {{ $summary['TIU']['wrong'] }}, kosong {{ $summary['TIU']['empty'] }}</div>
                    <div>TKP: dijawab {{ $summary['TKP']['answered'] }}, kosong {{ $summary['TKP']['empty'] }}</div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <h2 class="text-base font-semibold text-gray-900">Pembahasan</h2>
                <div class="mt-4 space-y-4">
                    @foreach ($answers as $index => $answer)
                        <details class="rounded-lg border border-gray-200 p-4">
                            <summary class="cursor-pointer text-sm font-semibold text-gray-900">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase">
                                    <span class="rounded bg-indigo-50 px-2 py-1 text-indigo-700">{{ $answer->question->category->code }}</span>
                                    <span class="rounded bg-blue-50 px-2 py-1 text-blue-700">Soal {{ $index + 1 }}</span>
                                    <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $answer->question->subcategory->name }}</span>
                                    <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">Skor {{ $answer->score }}</span>
                                </div>
                            </summary>
                            <div class="mt-4 text-sm leading-6 text-gray-800">
                                <p class="font-medium text-gray-900">{{ $answer->question->question_text }}</p>
                                <div class="mt-3 space-y-2">
                                    @foreach ($answer->question->options->sortBy('option_label') as $option)
                                        <div class="{{ $answer->selected_option_id === $option->id ? 'font-semibold text-indigo-700' : '' }}">
                                            {{ $option->option_label }}. {{ $option->option_text }}
                                            @if ($answer->question->score_type === 'binary' && $option->is_correct)
                                                <span class="text-green-700">(benar)</span>
                                            @elseif ($answer->question->score_type === 'weighted')
                                                <span class="text-gray-500">(skor {{ $option->score }})</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3 rounded bg-indigo-50 p-3 text-indigo-950">{{ $answer->question->explanation }}</div>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
