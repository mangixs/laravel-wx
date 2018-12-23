<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\user;
use App\models\admin\slide;
use App\models\front\nav;
use App\models\front\goods;
use App\models\front\shop;
use DB;

class GoodsController extends Controller
{

    public function detail(Request $request)
    {
        $id = $request->post('id');
        $userId = $request->post('user_id');
        $data = goods::find($id);
        $data['is_collection'] = $this->getUserCollection($userId,$id);
        return $this->returnRes($data);
    }
    private function getUserCollection($userId,$id)
    {
        $res = DB::table('goods_collection')->where(['goods_id'=>$id,'user_id'=>$userId])->first();
        if(empty($res)){
            return 0;
        }else{
            return 1;
        }
    }
    public function addCollection(Request $request)
    {
        $data['goods_id'] = $request->post('id');
        $data['user_id'] = $request->post('user_id');
        $data['insert_at'] = time();
        DB::table('goods_collection')->insert($data);
        return $this->returnRes();
    }
    public function cancelCollection(Request $request)
    {
        $id = $request->post('id');
        $userId = $request->post('user_id');
        DB::table('goods_collection')->where(['goods_id'=>$id,'user_id'=>$userId])->delete();
        return $this->returnRes();
    }
}
