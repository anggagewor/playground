<?php

namespace Anggagewor\Foundation\Providers;

use Anggagewor\Foundation\Console\Commands\MakeModuleCommand;
use Illuminate\Support\ServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/foundation.php', 'foundation'
        );
        $this->app->singleton('api.response', function () {
            return new \Anggagewor\Foundation\Helpers\ApiResponse;
        });
        $modulesPaths = config('foundation.modules_path', []);
        $namespacePrefix = config('foundation.namespace', 'App\\Modules\\');

        foreach ($modulesPaths as $modulesPath) {
            if (is_dir($modulesPath)) {
                foreach (glob($modulesPath.'/*', GLOB_ONLYDIR) as $modulePath) {
                    $moduleName = basename($modulePath);
                    $providerClass = $namespacePrefix."{$moduleName}\\Providers\\ModuleServiceProvider";

                    if (class_exists($providerClass)) {
                        $this->app->register($providerClass);
                    }
                }
            }
        }
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModuleCommand::class,
            ]);

            // Publish stubs
            $this->publishes([
                __DIR__.'/../../stubs' => base_path('stubs/foundation'),
            ], 'foundation-stubs');
        }
    }
}
