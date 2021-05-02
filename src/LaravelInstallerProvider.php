<?php

namespace Postbox\LaravelInstaller;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class LaravelInstallerProvider extends ServiceProvider
{
    protected $systemExtensions;
    protected $coreExtensions = ['openssl'];
    protected $missingExtensions = [];
    protected $fstream;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register the controller
        $this->app->make('Postbox\LaravelInstaller\Controllers\LaravelInstaller');
        $this->loadViewsFrom(__DIR__ . '/views', 'laravelinstaller');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->systemExtensions = get_loaded_extensions();
        $this->missingExtensions = array_diff($this->coreExtensions,$this->systemExtensions);
        $this->fstream = @fopen(base_path('storage/logs/laravel-'.date('Y-m-d').'.log'),'a');

        // activate routes file if installer has not been run
        if(config('laravelinstaller.installed') !== "1") {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        }

        // publish assets
        $this->publishes([
            __DIR__ . '/assets' => public_path('vendor/digitalbit/laravelinstaller'),
        ], 'laravelinstaller');

        // publish configuration
        $this->publishes([
            __DIR__ . '/config/laravelinstaller.php' => config_path('laravelinstaller.php')
        ],'laravelinstaller');

        // write some code to validate the installation
        // check storage folder permissions to enable writing log files
        if(!is_resource($this->fstream)) {
            chmod(storage_path(),777);
        }
        // perform a check for mandatory extensions and abort if not enabled
        if(env('APP_DEBUG') == true) {
            abort_if(count($this->missingExtensions) > 0,501,'Please enable '.implode(',',$this->missingExtensions).' extension(s) as it is not loaded or missing');
        } else {
            echo \json_encode('Please enable '.implode(',',$this->missingExtensions).' extension(s) as it is not loaded or missing');
            exit();
        }
    }
}
