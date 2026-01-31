<?php

namespace App\Models;

use App\Enums\Department;
use App\Enums\QuestionType;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentQuestion extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'question',
        'type',
        'department',
    ];

    protected $casts = [
        'type' => QuestionType::class,
        'department' => Department::class,
    ];

    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(Applicant::class, 'applicant_department_question')
            ->withTimestamps();
    }

    public function scopeSerious($query)
    {
        return $query->where('type', QuestionType::SERIOUS);
    }

    public function scopeTroll($query)
    {
        return $query->where('type', QuestionType::TROLL);
    }
}
