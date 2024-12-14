<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait HasSlug
{
    // handle slug on create
    public static function BootHasSlug()
    {
        static::creating(function ($model){
            if (Schema::hasColumn($model->getTable(), 'slug'))
                $model->slug = str()->slug($model->name ?? $model->title);
        });
    }
}
