<?php

namespace App\models\front;

use Illuminate\Database\Eloquent\Model;
use DB;
class shop extends Model
{
    protected $table = 'shop';
    public $timestamps = false;
    static public function allShop(){
		$ret=self::where('valid',1)->select('id','title')->orderBy('update_at','desc')->get();
		return $ret;
	}
}
