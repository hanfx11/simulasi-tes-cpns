<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    public const DIFFICULTIES = ['easy', 'medium', 'hard'];
    public const SCORE_TYPES = ['binary', 'weighted'];
    public const STATUSES = ['active', 'inactive'];

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'question_text',
        'explanation',
        'difficulty',
        'score_type',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function examAnswers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
}
