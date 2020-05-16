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

// Route models...
Route::post('/character/{character}/location/{location}/move', 'CharacterController@move')->name('character.move');
Route::post('/character/{character}/attack', 'CharacterController@attack')->name('character.attack');
Route::post('/inventory/item/{item}/equip', 'InventoryController@equipItem')->name('inventory.item.equip');
Route::post('/inventory/item/{item}/un-equip', 'InventoryController@unEquipItem')->name('inventory.item.un-equip');
Route::post('/inventory/item/{item}/move-to-store', 'StoreController@moveItemToStore')->name('inventory.item.move-to-store');
Route::post('/store/item/{item}/move-to-inventory', 'StoreController@moveItemToInventory')->name('store.item.move-to-inventory');
Route::post('/inventory/money/move-to-store', 'StoreController@moveMoneyToStore')->name('inventory.money.move-to-store');
Route::post('/store/money/move-to-inventory', 'StoreController@moveMoneyToInventory')->name('store.money.move-to-inventory');

// Simple routes...
Route::group(['middleware' => 'guest'], static function () {
    Route::get('/', static function () {
        return view('pages.index');
    })->name('index');
});

Route::group(['middleware' => ['auth', 'has.character']], static function () {
    Route::get('/home', static function () {
        $location = Auth::user()->character->location;
        return redirect()->route('location.show', compact('location'));
    })->name('home');
});

Auth::routes();

// Route resources...
Route::resource('inventory', 'InventoryController')->only('index');
Route::resource('store', 'StoreController')->only('index');
Route::resource('character', 'CharacterController')->only('create', 'store', 'show', 'update');
Route::resource('location', 'LocationController')->only(['show']);
Route::resource('battle', 'BattleController')->only(['show']);
Route::resource('message', 'MessageController')->only(['index']);
Route::resource('character.message', 'CharacterMessageController')->only(['index', 'store']);
Route::resource('character.profile-picture', 'ProfilePictureController')->only(['store', 'destroy']);
Route::resource('character.battle', 'CharacterBattleController')->only(['index']);


Route::group(['prefix' => 'admin'], static function () {
    Voyager::routes();
});
