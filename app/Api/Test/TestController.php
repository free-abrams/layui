<?php
namespace App\Api\Test;

use App\Models\RecordMaterial;
use Illuminate\Routing\Controller;
use App\Models\Categories;
use App\Jobs\TestQueue;
use App\Models\link;

class TestController extends Controller
{
	public function test()
	{
		$array = [1, 2, 3, 4, 5, 6];

		return response([
			'code' => 1,
			'msg' => $this->search($array, 1)
		]);
	}

	public function search($array = [], $value)
	{
		return $this->BinarySearch($array, 0, count($array) - 1, $value);
	}

	public function BinarySearch($array, $low, $high, $value)
	{
		$mid = intval(($low + $high)/2);

		switch ($value) {
			case $value == $array[$mid]:
				 return $mid;
				break;
			case $value > $array[$mid]:
				 return $this->BinarySearch($array, $mid + 1, $high, $value);
				break;
			case $value < $array[$mid]:
				 return $this->BinarySearch($array, $low, $mid - 1, $value);
				break;
			default:
				 return false;
				break;
		}
	}

	public function cate()
	{
		$lists = Categories::orderBy('left', 'asc')->get()->toArray();
		// 相邻的两条记录的右值第一条的右值比第二条的大那么就是他的父类
        // 我们用一个数组来存储上一条记录的右值，再把它和本条记录的右值比较，如果前者比后者小，说明不是父子关系，
        // 就用array_pop弹出数组，否则就保留
        // 两个循环而已，没有递归
        $parent = array();
        $arr_list = array();
        foreach($lists as $item){
 
            if(count($parent)){
                while (count($parent) -1 > 0 && $parent[count($parent) -1]['rgt'] < $item['rgt']){
                   array_pop($parent);
                }
            }
 
            $item['depath'] = count($parent);
            $parent[]   = $item;
            $arr_list[] = $item;
        }

        //显示树状结构
        foreach($arr_list as $a)
        {
            echo str_repeat('--', $a['depath']) . $a['title'] . '<br />';
        }
	}

	public function testJob()
	{
		$data = [
			'title' => date('Y-m-d H:i:s', time()),
			'link' => 'www.taobao.com'
		];
		
		$job = TestQueue::dispatch($data);

		return response([
			'code' => 1,
			'msg' => '成功'
		]);
	}
	
	public function sortArray()
	{
		
	}
}