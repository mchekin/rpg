<?php

use App\Contracts\Models\BattleInterface;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\ImageInterface;
use App\Contracts\Models\LocationInterface;
use App\Contracts\Models\MessageInterface;

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
Route::model("character", CharacterInterface::class);
Route::model("battle", BattleInterface::class);
Route::model("location", LocationInterface::class);
Route::model("message", MessageInterface::class);
Route::model("profile-image", ImageInterface::class);

Route::get('/character/{character}/location/{location}/move', 'CharacterController@getMove')
    ->name('character.move');

Route::get('/character/{character}/attack', 'CharacterController@getAttack')
    ->name('character.attack');

Route::get('/message/inbox', 'MessageController@inbox')->name('message.inbox');
Route::get('/message/sent', 'MessageController@sent')->name('message.sent');

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
Route::resource("location", "LocationController");
Route::resource("battle", "BattleController")->only(['show']);
Route::resource("character.message", "MessageController")->only(['index', 'store']);
Route::resource("character.profile-picture", "ProfilePictureController")->only(['store', 'destroy']);
