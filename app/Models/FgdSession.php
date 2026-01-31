<?php

namespace App\Models;

use App\Enums\FgdCategory;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FgdSession extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'schedule',
        'place',
        'category',
    ];

    protected $casts = [
        'schedule' => 'datetime',
        'category' => FgdCategory::class,
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(FgdGroup::class, 'session_id');
    }

    public function scopeByCategory($query, FgdCategory $category)
    {
        return $query->where('category', $category);
    }
}
