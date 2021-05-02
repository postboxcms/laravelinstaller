<?php
// Index route
Route::get('/', function() {
    if(config('laravelinstaller.installed') !== "1") {
        return redirect('/install');
    }
});

Route::group(['middleware' => ['web']], function () {
    // GET routes
    Route::get('/install', 'Postbox\LaravelInstaller\Controllers\LaravelInstaller@systemRequirements');
    Route::get('/install/application','Postbox\LaravelInstaller\Controllers\LaravelInstaller@appDetails');
    Route::get('/install/database','Postbox\LaravelInstaller\Controllers\LaravelInstaller@dbDetails');
    Route::get('/install/verify-details','Postbox\LaravelInstaller\Controllers\LaravelInstaller@verifyDetails');
    Route::get('/install/process-details','Postbox\LaravelInstaller\Controllers\LaravelInstaller@processDetails');


    // POST routes
    Route::post('/install/save/requirements','Postbox\LaravelInstaller\Controllers\LaravelInstaller@storeRequirements');
    Route::post('/install/save/application','Postbox\LaravelInstaller\Controllers\LaravelInstaller@storeAppDetails');
    Route::post('/install/save/database','Postbox\LaravelInstaller\Controllers\LaravelInstaller@storeDBDetails');
    Route::post('/install/save/verified','Postbox\LaravelInstaller\Controllers\LaravelInstaller@storeVerifiedData');
    Route::post('/install/save/environment','Postbox\LaravelInstaller\Controllers\LaravelInstaller@updateEnvironment');
    Route::post('/install/save/storage','Postbox\LaravelInstaller\Controllers\LaravelInstaller@createStorageLink');
    Route::post('/install/run/migrations','Postbox\LaravelInstaller\Controllers\LaravelInstaller@runMigrations');
});
