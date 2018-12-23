<?php

namespace App\models\front;

use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    protected $table = 'goods_tag';
    public $timestamps = false;
    public static function allTag()
    {
        $ret=self::where('valid',1)->select('id','title')->get();
        return $ret;
    }    
}
