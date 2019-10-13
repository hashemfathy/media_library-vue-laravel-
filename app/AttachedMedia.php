<?php

namespace App;

use App\CustomMedia;
use Illuminate\Database\Eloquent\Model;

class AttachedMedia extends Model
{
    public function customMedia()
    {
        return $this->belongsTo(CustomMedia::class);
    }
    public function users()
    {
        return $this->morphedByMany('App\AttachedMedia', 'attachedmediable');
    }
}
