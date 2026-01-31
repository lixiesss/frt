<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FgdGroup extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'topic_id',
        'session_id',
        'mentor_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(FgdTopic::class, 'topic_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(FgdSession::class, 'session_id');
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'group_id');
    }
}
