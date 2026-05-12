<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_session_id',
        'question_id',
        'selected_option_id',
        'score',
        'is_correct',
        'is_flagged',
        'answered_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'is_correct' => 'boolean',
            'is_flagged' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    public function examSession(): BelongsTo
    {
        return $this->belongsTo(ExamSession::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }
}
