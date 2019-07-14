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
Route::get('/character/{character}/location/{location}/move', 'CharacterController@getMove')
    ->name('character.move');

Route::get('/character/{character}/attack', 'CharacterController@getAttack')
    ->name('character.attack');

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
Route::resource("character", "CharacterController");
Route::resource("location", "LocationController")->only(['show']);
Route::resource("battle", "BattleController")->only(['show']);
Route::resource("message", "MessageController")->only(['index']);
Route::resource("character.message", "CharacterMessageController")->only(['index', 'store']);
Route::resource("character.profile-picture", "ProfilePictureController")->only(['store', 'destroy']);
Route::resource("character.battle", "CharacterBattleController")->only(['index']);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
