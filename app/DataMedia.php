<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class DataMedia extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * Register the conversions that should be performed.
     *
     * @return array
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('card')
            ->width(config('customMediaOptions.dimensions.card.width', 280))
            ->height(config('customMediaOptions.dimensions.card.height', 180));
        $this->addMediaConversion('thumb')
            ->width(config('customMediaOptions.dimensions.thumb.width', 100))
            ->height(config('customMediaOptions.dimensions.thumb.height', 100));
    }
}
