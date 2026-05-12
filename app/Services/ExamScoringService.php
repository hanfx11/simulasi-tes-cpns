<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Models\ExamAnswer;
use App\Models\ExamSession;

class ExamScoringService
{
    public function score(ExamSession $session, string $finalStatus = 'submitted'): ExamSession
    {
        $session->load(['answers.question.category', 'answers.selectedOption']);

        $scores = [
            'TWK' => 0,
            'TIU' => 0,
            'TKP' => 0,
        ];

        foreach ($session->answers as $answer) {
            $score = $this->scoreAnswer($answer);

            $answer->forceFill([
                'score' => $score['score'],
                'is_correct' => $score['is_correct'],
            ])->save();

            $categoryCode = $answer->question->category->code;

            if (isset($scores[$categoryCode])) {
                $scores[$categoryCode] += $score['score'];
            }
        }

        $passedTwk = $scores['TWK'] >= (int) AppSetting::valueFor('passing_grade_twk', 65);
        $passedTiu = $scores['TIU'] >= (int) AppSetting::valueFor('passing_grade_tiu', 80);
        $passedTkp = $scores['TKP'] >= (int) AppSetting::valueFor('passing_grade_tkp', 166);

        $session->forceFill([
            'finished_at' => now(),
            'status' => $finalStatus,
            'score_twk' => $scores['TWK'],
            'score_tiu' => $scores['TIU'],
            'score_tkp' => $scores['TKP'],
            'score_total' => array_sum($scores),
            'passed_twk' => $passedTwk,
            'passed_tiu' => $passedTiu,
            'passed_tkp' => $passedTkp,
            'passed_total' => $passedTwk && $passedTiu && $passedTkp,
        ])->save();

        return $session->refresh();
    }

    private function scoreAnswer(ExamAnswer $answer): array
    {
        if (! $answer->selectedOption) {
            return ['score' => 0, 'is_correct' => null];
        }

        if ($answer->question->score_type === 'weighted') {
            return [
                'score' => (int) $answer->selectedOption->score,
                'is_correct' => null,
            ];
        }

        $isCorrect = (bool) $answer->selectedOption->is_correct;

        return [
            'score' => $isCorrect ? 5 : 0,
            'is_correct' => $isCorrect,
        ];
    }
}
