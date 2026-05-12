<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'total_questions',
        'is_full_skd',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'total_questions' => 'integer',
            'is_full_skd' => 'boolean',
        ];
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_package_questions')
            ->withPivot('order_number')
            ->withTimestamps()
            ->orderByPivot('order_number');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(ExamSession::class);
    }
}
