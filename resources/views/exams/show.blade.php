<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ $session->examPackage->title }}</h1>
                <p class="text-sm text-gray-600">Soal {{ $activeNumber }} dari {{ $answers->count() }}</p>
            </div>
            <div class="text-lg font-semibold text-red-600" id="timer">--:--</div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 rounded-lg border border-indigo-100 bg-indigo-50 p-4 text-sm text-indigo-950">
                Soal latihan original berbasis pola kompetensi SKD CPNS. Bukan soal asli atau bocoran soal resmi.
            </div>

            <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
                <section class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase">
                        <span class="rounded bg-indigo-50 px-2 py-1 text-indigo-700">{{ $activeAnswer->question->category->code }}</span>
                        <span class="rounded bg-blue-50 px-2 py-1 text-blue-700">Soal {{ $activeNumber }}</span>
                        <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $activeAnswer->question->subcategory->name }}</span>
                        <span class="rounded bg-gray-100 px-2 py-1 text-gray-700">{{ $activeAnswer->question->difficulty }}</span>
                    </div>

                    <div class="mt-5 whitespace-pre-line text-base leading-7 text-gray-900">{{ $activeAnswer->question->question_text }}</div>

                    <div class="mt-6 space-y-3">
                        @foreach ($activeAnswer->question->options as $option)
                            <label class="block cursor-pointer rounded-lg border p-4 hover:border-indigo-300 {{ $activeAnswer->selected_option_id === $option->id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                <div class="flex gap-3">
                                    <input type="radio" name="selected_option_id" value="{{ $option->id }}" @checked($activeAnswer->selected_option_id === $option->id) class="mt-1" data-answer-url="{{ route('exams.answer', [$session, $activeAnswer]) }}">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $option->option_label }}</div>
                                        <div class="mt-1 text-sm leading-6 text-gray-800">{{ $option->option_text }}</div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex gap-2">
                            @if ($activeNumber > 1)
                                <a href="{{ route('exams.show', ['session' => $session, 'n' => $activeNumber - 1]) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Sebelumnya</a>
                            @endif
                            @if ($activeNumber < $answers->count())
                                <a href="{{ route('exams.show', ['session' => $session, 'n' => $activeNumber + 1]) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Selanjutnya</a>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('exams.flag', [$session, $activeAnswer]) }}">
                            @csrf
                            <button class="rounded-md border border-yellow-400 px-4 py-2 text-sm font-semibold text-yellow-800 hover:bg-yellow-50">
                                {{ $activeAnswer->is_flagged ? 'Hapus Ragu-ragu' : 'Tandai Ragu-ragu' }}
                            </button>
                        </form>
                    </div>
                </section>

                <aside class="space-y-4">
                    <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
                        <h2 class="text-sm font-semibold text-gray-900">Navigasi Soal</h2>
                        <div class="mt-4 grid grid-cols-5 gap-2">
                            @foreach ($answers as $index => $answer)
                                @php
                                    $number = $index + 1;
                                    $classes = 'bg-gray-100 text-gray-700';
                                    if ($answer->selected_option_id) {
                                        $classes = 'bg-green-100 text-green-800';
                                    }
                                    if ($answer->is_flagged) {
                                        $classes = 'bg-yellow-100 text-yellow-800';
                                    }
                                    if ($number === $activeNumber) {
                                        $classes = 'bg-blue-600 text-white';
                                    }
                                @endphp
                                <a href="{{ route('exams.show', ['session' => $session, 'n' => $number]) }}" class="flex h-10 items-center justify-center rounded-md text-sm font-semibold {{ $classes }}">{{ $number }}</a>
                            @endforeach
                        </div>
                    </div>

                    <form method="POST" action="{{ route('exams.submit', $session) }}" onsubmit="return confirm('Submit ujian sekarang? Jawaban tidak bisa diubah setelah submit.')" class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
                        @csrf
                        <button class="w-full rounded-md bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700">Submit Ujian</button>
                    </form>
                </aside>
            </div>
        </div>
    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let remaining = {{ $remainingSeconds }};
        const timer = document.getElementById('timer');
        const submitUrl = @json(route('exams.submit', $session));

        function renderTimer() {
            const minutes = Math.floor(remaining / 60).toString().padStart(2, '0');
            const seconds = (remaining % 60).toString().padStart(2, '0');
            timer.textContent = `${minutes}:${seconds}`;

            if (remaining <= 0) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = submitUrl;
                form.innerHTML = `<input type="hidden" name="_token" value="${csrf}">`;
                document.body.appendChild(form);
                form.submit();
            }

            remaining -= 1;
        }

        renderTimer();
        setInterval(renderTimer, 1000);

        document.querySelectorAll('input[name="selected_option_id"]').forEach((input) => {
            input.addEventListener('change', async (event) => {
                await fetch(event.target.dataset.answerUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({
                        selected_option_id: event.target.value,
                    }),
                });
            });
        });
    </script>
</x-app-layout>
