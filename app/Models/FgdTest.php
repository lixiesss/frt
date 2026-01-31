<?php

namespace App\Models;

use App\Enums\TestType;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FgdTest extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'question',
        'type',
        'topic_id',
    ];

    protected $casts = [
        'type' => TestType::class,
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(FgdTopic::class, 'topic_id');
    }

    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(Applicant::class, 'applicant_fgd_test', 'test_id', 'applicant_id')
            ->using(ApplicantFgdTest::class)
            ->withPivot('answer')
            ->withTimestamps();
    }

    public function scopePretest($query)
    {
        return $query->where('type', TestType::PRETEST);
    }

    public function scopePosttest($query)
    {
        return $query->where('type', TestType::POSTTEST);
    }
}
