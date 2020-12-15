<?php

namespace App\Models;
// 房型
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

class Scale extends BaseModel
{
    //
    protected $table = "scales";

    public function room()
    {
        return $this->hasMany(Room::class, 'store_id');
    }
    
    public function delete()
    {
    	// 判断这个房型下时候包含房间
	    //dd($this);
	    $room = Room::where('scale_id', $this->id)->first();
	    if(!empty($room)){
	        // 有房间不给删除
		    $error = new MessageBag([
		        'title'   => '提示...',
		        'message' => '这个房型下存在房间不能删除....',
		    ]);
		
		    return back()->with(compact('error'));
	    }
	    return parent::delete();
    }
}
