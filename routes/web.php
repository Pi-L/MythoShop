<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'HomeController@index')->name('main.index');

    Route::resource('/product', 'ProductController',
    [
    'names' => [
        'index' => 'product.index',
        'show' => 'product.show',
        'store' => 'product.store',
        'update' => 'product.update',
        'edit' => 'product.edit',
        'create' => 'product.create',
        'destroy' => 'product.destroy'
    ]
    ]);

    Route::prefix('categorie')->group(function () {
        Route::get('/', 'CategorieController@index')->name('categorie.index');
        Route::get('/{id}', 'CategorieController@show')->name('categorie.show');
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', 'CartController@index')->name('cart.index');
        Route::get('/add/{id?}', 'CartController@add')->name('cart.add');
        Route::get('/remove/{id?}', 'CartController@remove')->name('cart.remove');
        Route::post('/updaterelative', 'CartController@updateRelative')->name('cart.updaterelative');
        Route::post('/update', 'CartController@update')->name('cart.update');

        Route::post('/updateShippingChoice', 'CartController@updateShippingChoice')->name('cart.updateShippingChoice');
    });

    Route::group(['middleware' => 'auth'], function () {

        // order
        Route::get('order/shipping', 'OrderController@shipping')->name('order.shipping');
        Route::post('order/storeaddresse', 'OrderController@storeAddresse')->name('order.storeAddresse');
        Route::get('order/checkout/{id}', 'OrderController@checkout')->name('order.checkout');
        Route::get('order/payment', 'OrderController@payment')->name('order.payment');
        Route::post('order/confirmation', 'OrderController@confirmation')->name('order.confirmation');


        // user
        Route::get('user/welcome', 'UserController@welcome')->name('user.welcome');
        Route::get('user/createaddresse', 'UserController@createAddresse')->name('user.createAddresse');
        Route::post('user/storeaddresse', 'UserController@storeAddresse')->name('user.storeAddresse');
    });

});


Auth::routes();

