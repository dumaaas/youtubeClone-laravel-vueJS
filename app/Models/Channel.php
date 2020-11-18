<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Models\Media;

class Channel extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        if($this->media->first()) {
            return $this->media->first()->getFullUrl();
        } else {
            return null;
        }
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }

    public function editable()
    {
        if(!auth()->check()) return false;
        return $this->user_id == auth()->user()->id;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
