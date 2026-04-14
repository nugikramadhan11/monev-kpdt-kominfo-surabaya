<?php

namespace App\Providers;

use App\Models\Posting;
use App\Policies\PostingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Posting::class => PostingPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
