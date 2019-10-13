<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class MediaLibraryService 
{
    public function attachMediaToModel(Model $model,Array $media_ids)
    {
        $model->attachedMedia()->sync($media_ids);
        return $model;
    }
}
?>