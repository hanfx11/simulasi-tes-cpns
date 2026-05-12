<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSession extends Model
{
    use HasFactory;

    public const MODES = ['full', 'practice', 'review', 'wrong_only'];
    public const STATUSES = ['ongoing', 'submitted', 'expired'];

    protected $fillable = [
        'user_id',
        'exam_package_id',
        'mode',
        'started_at',
        'finished_at',
        'duration_seconds',
        'status',
        'score_total',
        'score_twk',
        'score_tiu',
        'score_tkp',
        'passed_twk',
        'passed_tiu',
        'passed_tkp',
        'passed_total',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'duration_seconds' => 'integer',
            'score_total' => 'integer',
            'score_twk' => 'integer',
            'score_tiu' => 'integer',
            'score_tkp' => 'integer',
            'passed_twk' => 'boolean',
            'passed_tiu' => 'boolean',
            'passed_tkp' => 'boolean',
            'passed_total' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function examPackage(): BelongsTo
    {
        return $this->belongsTo(ExamPackage::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
}
