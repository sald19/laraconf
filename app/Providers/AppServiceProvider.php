<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Tables\Actions\CreateAction;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CreateAction::configureUsing(fn($action) => $action->slideOver());
    }
}
