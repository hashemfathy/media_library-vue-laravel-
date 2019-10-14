<?php

namespace App;

use App\CustomMedia;
use Illuminate\Database\Eloquent\Model;

class AttachedMedia extends Model
{
    protected $table="attachedmediables";

    public function customMedia()
    {
        return $this->belongsTo(CustomMedia::class,'attached_media_id');
    }

    public function users()
    {
        return $this->morphedByMany('App\AttachedMedia', 'attachedmediable');
    }
}
