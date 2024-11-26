<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // A helper to easily configure and get the per page or limit request
        Request::macro('perPage', function ($perPage = 10) {
            return (int) request()->input('per_page', request()->input('limit', $perPage));
        });
    }
}
