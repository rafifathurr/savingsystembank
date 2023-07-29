<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('transactions.report.index');
    }else{
        return redirect()->route('signin.index');
    }
});

Route::namespace('App\Http\Controllers')->group(function (){

    Route::prefix('auth')->name('signin.')->group(function () {
        Route::get('/signin', 'AuthController@index')->name('index');
        Route::get('/signup', 'AuthController@signup')->name('signup');
        Route::post('/signin', 'AuthController@authenticate')->name('authenticate');
        Route::post('/signup', 'AuthController@register')->name('register');
        Route::post('/signout', 'AuthController@logout')->name('signout');
    });

    Route::prefix('home')->name('home.')->group(function () {
        Route::get('/', 'HomeController@index')->name('index');
    });

    // Route::prefix('type')->name('type.')->group(function () {
    //     Route::get('/', 'TypeController@index')->name('index');
    //     Route::get('create', 'TypeController@create')->name('create');
    //     Route::post('store', 'TypeController@store')->name('store');
    //     Route::post('destroy', 'TypeController@destroy')->name('destroy');
    // });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', 'TransactionsController@index')->name('index');
        Route::get('create', 'TransactionsController@create')->name('create');
        Route::post('store', 'TransactionsController@store')->name('store');
        Route::post('/getStatus', 'TransactionsController@getStatus')->name('getStatus');

        Route::prefix('report')->name('report.')->group(function () {
            Route::get('/', 'TransactionsController@report')->name('index');
            Route::post('/scopeData', 'TransactionsController@scopeReport')->name('scopeData');
            Route::get('/income', 'TransactionsController@income')->name('income');
            Route::post('/scopeIncome', 'TransactionsController@scopeIncome')->name('scopeIncome');
            Route::get('/outcome', 'TransactionsController@outcome')->name('outcome');
            Route::post('/scopeOutcome', 'TransactionsController@scopeOutcome')->name('scopeOutcome');
        });

    });

});
