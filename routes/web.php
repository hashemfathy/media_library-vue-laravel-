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

use App\CustomMedia;
use App\Http\Resources\MediaResource;
use App\DataMedia;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'media-library'], function () {

    Route::get('', 'MediaLibraryController@index')->name('media.library');

    Route::post('upload-media', 'MediaLibraryController@store');

    Route::delete('delete-media/{media}', 'MediaLibraryController@delete');

    Route::put('update-media/{media}', 'MediaLibraryController@update');

    Route::get('images', 'MediaLibraryController@mediaData');
});

Route::get('users', function (Request $request) {
    return UserResource::collection(User::all());
});
