<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', static function (Request $request) {
    return $request->user();
});

Route::middleware('auth', 'has.character')->namespace('Api')->group(static function () {

    Route::post('/inventory/item/{item}/move-to-store', 'StoreController@moveItemToStore')->name('inventory.item.move-to-store');
    Route::post('/store/item/{item}/move-to-inventory', 'StoreController@moveItemToInventory')->name('store.item.move-to-inventory');
    Route::post('/inventory/money/move-to-store', 'StoreController@moveMoneyToStore')->name('inventory.money.move-to-store');
    Route::post('/store/money/move-to-inventory', 'StoreController@moveMoneyToInventory')->name('store.money.move-to-inventory');

});
