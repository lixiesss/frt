<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodingQuestion extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'question',
        'image_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(CodingTestSubmission::class, 'question_id');
    }
}
