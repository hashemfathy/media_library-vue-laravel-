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


Route::get('media-library', function () {
    return view('mediaLibrary');
})->name('media.library');


Route::post('upload-media', function (Request $request) {
    if ($media = DataMedia::find(1)) {
        $media
            ->addMedia($request->file)
            ->withCustomProperties(['user' => request()->user()])
            ->toMediaCollection();
    } else {
        $media = new DataMedia;
        $media->save();
        $media
            ->addMedia($request->file)
            ->withCustomProperties(['user' => request()->user()])
            ->toMediaCollection();
    }
    $media_data = [
        'url' => $media->getMedia()[count($media->getMedia()) - 1]->getFullUrl(),
        'data' => $media->getMedia()[count($media->getMedia()) - 1]
    ];
    return response()->json([
        'media' => $media_data
    ], 200);
});

Route::delete('delete-media/{media}', function (Request $request, Media $media) {

    $media->delete();
    return response()->json([
        'message' => 'no ya naaaas'
    ], 200);
});

Route::put('update-media/{media}', function (Request $request, Media $media) {

    $data = [
        'user' => $media->custom_properties['user'] ?? null,
        'information' => $request->information ?? null,
    ];
    \Log::info($data);
    $media->custom_properties = $data;
    if ($data['information']['title']) {
        $media->name = $data['information']['title'];
        $media->save();
    }
    $media->update();


    return response()->json([
        'media' => new mediaResource($media)
    ], 200);
});

Route::get('images', function (Request $request) {
    $all_media = CustomMedia::filterName($request->name)
        ->filterType($request->type)
        ->filterUploadedBy($request->uploaded_by)
        ->paginate(40);
    return mediaResource::collection($all_media);
});

Route::get('users', function (Request $request) {
    return UserResource::collection(User::all());
});

// Route::get('media-library', function (Request $request) {
//     return view('mediaLibrary');
// });
