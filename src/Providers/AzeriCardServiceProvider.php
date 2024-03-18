<?php

namespace ArifAbdd\Azericard\Providers;

use ArifAbdd\Azericard\Azericard;
use ArifAbdd\Azericard\Client;
use ArifAbdd\Azericard\Contracts\ClientContract;
use ArifAbdd\Azericard\Contracts\SignatureGeneratorContract;
use ArifAbdd\Azericard\Options;
use ArifAbdd\Azericard\SignatureGenerator;
use Illuminate\Support\ServiceProvider;

class AzeriCardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/azericard.php', 'azericard');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/azericard.php' => config_path('azericard.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ClientContract::class, static function () {
            return new Client();
        });

        $this->app->singleton(SignatureGeneratorContract::class, static function () {
            return new SignatureGenerator(app('config')->get('azericard.keys', []));
        });

        $this->app->bind(Azericard::class, static function () {
            return new Azericard(
                app(ClientContract::class),
                app(SignatureGeneratorContract::class),
                new Options(app('config')->get('azericard', []))
            );
        });
    }
}
