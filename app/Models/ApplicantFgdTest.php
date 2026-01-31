<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantFgdTest extends Pivot
{
    public $incrementing = false;

    protected $fillable = [
        'applicant_id',
        'test_id',
        'answer',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(FgdTest::class, 'test_id');
    }
}
