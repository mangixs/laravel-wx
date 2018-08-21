<?php
namespace App\Http\Controllers\test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use App\models\admin\staff;
use App\Jobs\testTag;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller{
	public function index(){
		$tmp=[758,65,45,32315,18,65,759,75,421,5,31,769,751,64,923,10];
		$ret=$this->mysort($tmp);
		p($ret);
	}
	public function mysort($arr){
		for ($i=0; $i < count($arr); $i++) { 
			for ($j=0; $j < count($arr)-1 ; $j++) { 
				if ( $arr[$j] < $arr[ $j +1 ]) {
					$tmp=$arr[$j];
					$arr[$j]=$arr[$j+1];
					$arr[$j+1]=$tmp;
				}
			}
		}
		return $arr;
	}
}