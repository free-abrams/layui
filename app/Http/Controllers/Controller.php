<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use FreeAbrams\Functions\Arr;

class TestController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function test()
    {
    	$arr = [1, 2];
        $arr = Arr::AddHeader($arr, '', '全部');
        dd(int(3/2));
        return Response()->json($arr);
    }
}
