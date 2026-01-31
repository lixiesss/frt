<?php

namespace App\Models;

use App\Enums\Department;
use App\Enums\Gender;
use App\Enums\Major;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Authenticatable
{
    use HasFactory, HasUuid;

    protected $appends = ['role'];
    public function getRoleAttribute(): string
    {
        return 'applicant';
    }

    protected $fillable = [
        'name',
        'nrp',
        'major',
        'gpa',
        'gender',
        'visi',
        'misi',
        'value',
        'cv_path',
        'stage',
        'first_choice_department',
        'first_choice_motivation',
        'first_choice_commitment',
        'first_choice_portfolio_path',
        'second_choice_department',
        'second_choice_motivation',
        'second_choice_commitment',
        'second_choice_portfolio_path',
        'department_answer_path',
        'group_id',
        'requires_coding_test',
        'is_draft',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'gpa' => 'decimal:2',
        'gender' => Gender::class,
        'major' => Major::class,
        'first_choice_department' => Department::class,
        'second_choice_department' => Department::class,
        'stage' => 'integer',
        'requires_coding_test' => 'boolean',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(FgdGroup::class, 'group_id');
    }

    public function departmentQuestions(): BelongsToMany
    {
        return $this->belongsToMany(DepartmentQuestion::class, 'applicant_department_question')
            ->withTimestamps();
    }

    public function fgdTests(): BelongsToMany
    {
        return $this->belongsToMany(FgdTest::class, 'applicant_fgd_test', 'applicant_id', 'test_id')
            ->using(ApplicantFgdTest::class)
            ->withPivot('answer')
            ->withTimestamps();
    }

    public function codingTestSubmissions(): HasMany
    {
        return $this->hasMany(CodingTestSubmission::class);
    }

    public function scopeByDepartmentChoice($query, string $departmentId)
    {
        return $query->where(function ($q) use ($departmentId) {
            $q->where('first_choice_department', $departmentId)
              ->orWhere('second_choice_department', $departmentId);
        });
    }

    public function scopeAtStage($query, int $stage)
    {
        return $query->where('stage', $stage);
    }

    public function scopeRequiresCodingTest($query)
    {
        return $query->where('requires_coding_test', true);
    }

    public function scopeSubmitted($query)
    {
        return $query->where('is_draft', false);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_draft', true);
    }
}
