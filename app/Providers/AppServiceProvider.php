<?php

namespace App\Providers;

use App\Models\Applicant;
use App\Models\DepartmentQuestion;
use App\Models\FgdGroup;
use App\Policies\ApplicantPolicy;
use App\Policies\DepartmentQuestionPolicy;
use App\Policies\FgdGroupPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Applicant::class, ApplicantPolicy::class);
        Gate::policy(DepartmentQuestion::class, DepartmentQuestionPolicy::class);
        Gate::policy(FgdGroup::class, FgdGroupPolicy::class);
    }
}
