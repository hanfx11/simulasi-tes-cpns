<?php

namespace App\Http\Controllers;

use App\Models\ExamAnswer;
use App\Models\ExamPackage;
use App\Models\ExamSession;
use App\Models\QuestionOption;
use App\Services\ExamScoringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function start(Request $request, ExamPackage $package): RedirectResponse
    {
        abort_unless($package->status === 'active', 404);

        $questionIds = $package->questions()->pluck('questions.id');
        abort_if($questionIds->isEmpty(), 422, 'Paket ujian belum memiliki soal.');

        $session = ExamSession::query()->create([
            'user_id' => $request->user()->id,
            'exam_package_id' => $package->id,
            'mode' => $package->is_full_skd ? 'full' : 'practice',
            'started_at' => now(),
            'duration_seconds' => $package->duration_minutes * 60,
            'status' => 'ongoing',
        ]);

        foreach ($questionIds as $questionId) {
            $session->answers()->create([
                'question_id' => $questionId,
            ]);
        }

        return redirect()->route('exams.show', $session);
    }

    public function show(Request $request, ExamSession $session, ExamScoringService $scoring): View|RedirectResponse
    {
        $this->ensureSessionOwner($request, $session);

        if ($session->status !== 'ongoing') {
            return redirect()->route('exams.result', $session);
        }

        if ($this->remainingSeconds($session) <= 0) {
            $scoring->score($session, 'expired');

            return redirect()->route('exams.result', $session);
        }

        $answers = $this->orderedAnswers($session);
        $number = max(1, min((int) $request->query('n', 1), $answers->count()));
        $activeAnswer = $answers->values()->get($number - 1);

        return view('exams.show', [
            'session' => $session->load('examPackage'),
            'answers' => $answers->values(),
            'activeAnswer' => $activeAnswer->load(['question.category', 'question.subcategory', 'question.options' => fn ($query) => $query->orderBy('option_label')]),
            'activeNumber' => $number,
            'remainingSeconds' => $this->remainingSeconds($session),
        ]);
    }

    public function answer(Request $request, ExamSession $session, ExamAnswer $answer): JsonResponse
    {
        $this->ensureSessionOwner($request, $session);
        abort_unless($session->status === 'ongoing', 403);
        abort_unless($answer->exam_session_id === $session->id, 404);

        $validated = $request->validate([
            'selected_option_id' => ['nullable', 'integer', 'exists:question_options,id'],
        ]);

        $selectedOptionId = $validated['selected_option_id'] ?? null;

        if ($selectedOptionId) {
            $option = QuestionOption::query()->findOrFail($selectedOptionId);
            abort_unless($option->question_id === $answer->question_id, 422);
        }

        $answer->update([
            'selected_option_id' => $selectedOptionId,
            'answered_at' => $selectedOptionId ? now() : null,
        ]);

        return response()->json([
            'saved' => true,
            'answer_id' => $answer->id,
            'selected_option_id' => $selectedOptionId,
        ]);
    }

    public function flag(Request $request, ExamSession $session, ExamAnswer $answer): RedirectResponse
    {
        $this->ensureSessionOwner($request, $session);
        abort_unless($session->status === 'ongoing', 403);
        abort_unless($answer->exam_session_id === $session->id, 404);

        $answer->update([
            'is_flagged' => ! $answer->is_flagged,
        ]);

        return back();
    }

    public function submit(Request $request, ExamSession $session, ExamScoringService $scoring): RedirectResponse
    {
        $this->ensureSessionOwner($request, $session);

        if ($session->status === 'ongoing') {
            $status = $this->remainingSeconds($session) <= 0 ? 'expired' : 'submitted';
            $scoring->score($session, $status);
        }

        return redirect()->route('exams.result', $session);
    }

    public function result(Request $request, ExamSession $session): View
    {
        $this->ensureSessionOwner($request, $session);

        abort_if($session->status === 'ongoing', 403);

        $answers = $this->orderedAnswers($session);
        $answers->each(fn (ExamAnswer $answer) => $answer->loadMissing(['question.category', 'question.subcategory', 'question.options', 'selectedOption']));

        return view('exams.result', [
            'session' => $session->load('examPackage'),
            'answers' => $answers,
            'summary' => $this->summary($answers),
        ]);
    }

    private function ensureSessionOwner(Request $request, ExamSession $session): void
    {
        abort_unless($session->user_id === $request->user()->id, 403);
    }

    private function remainingSeconds(ExamSession $session): int
    {
        $startedAt = $session->started_at ?? now();
        $duration = $session->duration_seconds ?? 0;

        return max(0, $duration - $startedAt->diffInSeconds(now()));
    }

    private function orderedAnswers(ExamSession $session): Collection
    {
        $answers = $session->answers()
            ->with(['question.category', 'question.subcategory', 'selectedOption'])
            ->get()
            ->keyBy('question_id');

        if (! $session->examPackage) {
            return $answers->values();
        }

        return $session->examPackage->questions()
            ->pluck('questions.id')
            ->map(fn ($questionId) => $answers->get($questionId))
            ->filter()
            ->values();
    }

    private function summary(Collection $answers): array
    {
        $summary = [
            'TWK' => ['correct' => 0, 'wrong' => 0, 'empty' => 0],
            'TIU' => ['correct' => 0, 'wrong' => 0, 'empty' => 0],
            'TKP' => ['answered' => 0, 'empty' => 0],
        ];

        foreach ($answers as $answer) {
            $code = $answer->question->category->code;

            if ($code === 'TKP') {
                $answer->selected_option_id ? $summary['TKP']['answered']++ : $summary['TKP']['empty']++;
                continue;
            }

            if (! $answer->selected_option_id) {
                $summary[$code]['empty']++;
            } elseif ($answer->is_correct) {
                $summary[$code]['correct']++;
            } else {
                $summary[$code]['wrong']++;
            }
        }

        return $summary;
    }
}
