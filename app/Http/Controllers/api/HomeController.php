<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\models\user;
use Illuminate\Http\Request;
use App\models\admin\slide;

class HomeController extends Controller{
    public function banner()
    {
        $data = slide::where('valid',1)->select(['id','title','img'])->get();
        $base_url = getenv('APP_URL');
        foreach($data as $k=>&$v){
            $v->img = $base_url.$v->img;
        }
        return response()->json(['result'=>'SUCCESS','msg'=>'ok','data'=>$data]);
    }
}