<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        $this->addBladeDirectives();
    }

    /**
     *
     */
    private function addBladeDirectives()
    {
        // Add a blade formatter for price attributes
        \Blade::directive('price', function ($expression) {
            return "<?= \"&euro; \" . number_format($expression, 2, ',', '.') ?>";
        });

    }
}
