<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamPackageQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_package_id',
        'question_id',
        'order_number',
    ];

    public function examPackage(): BelongsTo
    {
        return $this->belongsTo(ExamPackage::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
