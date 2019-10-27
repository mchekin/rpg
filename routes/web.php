<?php

use App\Battle;
use App\Character;
use App\Image;
use App\Location;
use App\Message;

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

// Simple routes...
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('pages.index');
    })->name('index');
});

Route::group(['middleware' => ['auth', 'has.character']], function () {
    Route::get('/home', function () {
        $location = Auth::user()->character->location;
        return redirect()->route('location.show', compact('location'));
    })->name('home');
});

Auth::routes();

// Route resources...
Route::resource("inventory", "InventoryController")->only('index');
Route::resource("character", "CharacterController")->only('create', 'store', 'show', 'update');
Route::resource("location", "LocationController")->only(['show']);
Route::resource("battle", "BattleController")->only(['show']);
Route::resource("message", "MessageController")->only(['index']);
Route::resource("character.message", "CharacterMessageController")->only(['index', 'store']);
Route::resource("character.profile-picture", "ProfilePictureController")->only(['store', 'destroy']);
Route::resource("character.battle", "CharacterBattleController")->only(['index']);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
