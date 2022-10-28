<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth', 'share'], 'namespace' => '\\App\\Http\\Controllers\\'], function () {

    Route::get('/two-factory/login', 'Auth\\TfaController@index')->name('auth.tfa.index');
    Route::post('/two-factory/login', 'Auth\\TfaController@login')->name('auth.tfa.login');

    Route::group(['middleware' => 'tfa'], function () {

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/users/{id}/login', 'UserController@loginAsAdmin')->name('user.loginAsAdmin');
        Route::get('/users/admin', 'UserController@loginToAdmin')->name('user.loginToAdmin');

        Route::group(['middleware' => ['page.authorize']], function () {

            Route::resource('page-groups', 'PageGroupController');

            Route::group(['as' => 'user.'], function () {
                Route::get('/users', 'UserController@index')->name('index');
                Route::get('/users/create', 'UserController@create')->name('create');
                Route::post('/users/create', 'UserController@store')->name('store');
                Route::get('/users/{id}', 'UserController@edit')->name('edit');
                Route::put('/users/{id}', 'UserController@update')->name('update');
                Route::delete('/users/{id}', 'UserController@delete')->name('delete');
            });

            Route::group(['as' => 'page.'], function () {
                Route::get('/pages', 'PageController@index')->name('index');
                Route::get('/pages/create', 'PageController@create')->name('create');
                Route::post('/pages/create', 'PageController@store')->name('store');
                Route::get('/pages/{id}', 'PageController@edit')->name('edit');
                Route::put('/pages/{id}', 'PageController@update')->name('update');
                Route::delete('/pages/{id}', 'PageController@delete')->name('delete');
            });

        });

        Route::group(['as' => 'profile.'], function () {
            Route::get('/profile', 'ProfileController@edit')->name('edit');
            Route::put('/profile', 'ProfileController@update')->name('update');
        });

        Route::group(['as' => 'tfa.'], function () {
            Route::get('/two-factory', 'TfaController@index')->name('index');
            Route::put('/two-factory/enable', 'TfaController@enable')->name('enable');
            Route::put('/two-factory/disable', 'TfaController@disable')->name('disable');
        });

    });

});

require __DIR__ . '/auth.php';
