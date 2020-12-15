<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class News extends BaseModel
{
    public function setImagesUrlAttribute($value)
    {
        if(Route::currentRouteName() == 'news.index') {
            return $value = env('ALIOSS_HOST').'/'.$value.'?x-oss-process=image/resize,w_40';
        }

        return $value;
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
}
