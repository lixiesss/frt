<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FgdTopic extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tests(): HasMany
    {
        return $this->hasMany(FgdTest::class, 'topic_id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(FgdGroup::class, 'topic_id');
    }
}
