<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::resource('tracks', 'TrackController', ['except' => ['create', 'update', 'show', 'edit']]);
Route::get('track-categories/{q}', 'TrackController@getCategories')->name('tracks.categories');
Route::get('tracks-filtered/{date1}/{date2?}', 'TrackController@getTracksByDate')->name('tracks.filtered');

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');