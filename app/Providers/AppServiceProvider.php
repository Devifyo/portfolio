<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
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
        foreach ([
            storage_path('framework/views/livewire/classes'),
            storage_path('framework/views/livewire/views'),
        ] as $path) {
            if (! File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            @chmod($path, 0777);
        }
    }
}
