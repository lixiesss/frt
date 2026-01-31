<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodingTestSubmission extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'applicant_id',
        'question_id',
        'answer_file_path',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(CodingQuestion::class, 'question_id');
    }
}
