<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class CustomMedia extends BaseMedia
{
    protected $table = 'media';
    /**
     * filterName function
     * 
     * @param Builder $query
     * @return void
     */
    public function scopeFilterName(Builder $query, $value = null)
    {
        if ($value) $query->where("name", "LIKE", "%{$value}%");
    }

    /**
     * filterType function
     *
     * @param Builder $query
     * @return void
     */
    public function scopeFilterType(Builder $query, $value = null)
    {
        if ($value) $query->where("mime_type", "LIKE", "%{$value}%");
    }
    /**
     * filterUploadedBy function
     *
     * @param Builder $query
     * @return void
     */
    public function scopeFilterUploadedBy(Builder $query, $value = null)
    {
        if ($value) $query->where("custom_properties->user", $value);
    }

    /**
     * filterType function
     *
     * @param Builder $query
     * @return void
     */
    public function scopeFilterDate(Builder $query, $value = null)
    {
        if ($value) $query->where("created_at", $value);
    }
}
