<?php

namespace App\Models;

use App\Enums\Department;
use App\Enums\Major;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasUuid;

    protected $appends = ['role'];
    public function getRoleAttribute(): string
    {
        return 'admin';
    }

    protected $fillable = [
        'name',
        'email',
        'department',
        'major',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'major' => Major::class,
        'department' => Department::class,
    ];

    public function managesDepartment(Department $department): bool
    {
        return $this->department === $department;
    }
}
