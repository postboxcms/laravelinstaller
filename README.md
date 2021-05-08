# Laravel Installer
Laravel installer is an independent plugin to generate an installation wizard for your laravel application.

## Installation

### Download the package
Enter the root folder of your project in terminal and run:
```bash
composer require postboxcms/laravelinstaller
````
### Publish assets
To publish the assets run the following command:
```bash
php artisan vendor:publish --tag=laravelinstaller
````
### Add service provider
Edit ```config/app.php``` and add the following line under ````'providers'```` array:
```bash
Postbox\LaravelInstaller\LaravelInstallerProvider::class
````
### Add middleware
Edit ```app/Http/Kernel.php``` and add the following to ````$middleware```` array:
```bash
\Postbox\LaravelInstaller\Middleware\VerifyInstallation::class
````
### Laravel preconfiguration
To avoid the string length error while migrations being re-run edit ````app/Providers/AppServiceProvider.php```` and make a few changes to it.

1. On top of the file add the ```Schema``` facade:
    ```bash
    use Illuminate\Support\Facades\Schema;
    ````
2. In the ````boot()```` function add the following line:
    ```bash
    Schema::defaultStringLength(191); 
    ````
Now run your application using ````php artisan serve```` or through the url and enjoy.
