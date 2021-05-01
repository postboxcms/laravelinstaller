<?php
// Index route
Route::get('/', function() {
    if(config('laravelinstaller.status') !== true) {
        return redirect('/install');
    }
});

Route::group(['middleware' => ['web']], function () {
    // GET routes
    Route::get('/install', 'Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@systemRequirements');
    Route::get('/install/application','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@appDetails');
    Route::get('/install/database','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@dbDetails');
    Route::get('/install/verify-details','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@verifyDetails');
    Route::get('/install/process-details','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@processDetails');


    // POST routes
    Route::post('/install/save/requirements','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@storeRequirements');
    Route::post('/install/save/application','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@storeAppDetails');
    Route::post('/install/save/database','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@storeDBDetails');
    Route::post('/install/save/verified','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@storeVerifiedData');
    Route::post('/install/save/environment','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@updateEnvironment');
    Route::post('/install/save/storage','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@createStorageLink');
    Route::post('/install/run/migrations','Digitalbit\LaravelInstaller\Controllers\LaravelInstaller@runMigrations');
});
