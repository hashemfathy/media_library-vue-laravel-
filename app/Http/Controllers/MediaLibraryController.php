<?php

namespace App\Http\Controllers;

use App\CustomMedia;
use App\DataMedia;
use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaLibraryController extends Controller
{
    public function index()
    {
        return view('mediaLibrary');
    }

    public function store(Request $request)
    {
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
    }

    public function delete(Request $request, Media $media)
    {
        $media->delete();
        return response()->json([
            'message' => 'no ya naaaas'
        ], 200);
    }

    public function update(Request $request, Media $media)
    {
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
            'media' => new MediaResource($media)
        ], 200);
    }

    public function mediaData(Request $request)
    {
        $all_media = CustomMedia::filterName($request->name)
            ->filterType($request->type)
            ->filterDate($request->date)
            ->filterUploadedBy($request->uploaded_by)
            ->paginate(40);
        return mediaResource::collection($all_media);
    }
}
