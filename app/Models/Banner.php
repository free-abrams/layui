<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends BaseModel
{
//    public function setImagesUrlAttribute($pictures)
//	{
//	    if (is_array($pictures)) {
//	    	foreach ($pictures as $k => $v) {
//	    		$host = env('ALIOSS_HOST'). '/';
//
//	    		if(!strstr($v,$host)) {
//	    		    $pictures[$k] = $host . $v;
//			    }
//
//	    	}
//	        $this->attributes['images_url'] = json_encode($pictures);
//	    }
//	}
//
//	public function getImagesUrlAttribute($pictures)
//	{
//	    return json_decode($pictures, true);
//	}

	public function setImagesUrlAttribute($pictures)
	{
		$this->attributes['images_url'] = env('ALIOSS_HOST'). '/' . $pictures;
	}
}
