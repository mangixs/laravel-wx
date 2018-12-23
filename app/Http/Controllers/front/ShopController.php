<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\front\shop;
use DB;
use App\libraries\classes\FormCheck;
use App\libraries\classes\search;

class ShopController extends Controller
{
   
    public function index()
    {
        $data['title'] = '店铺管理';
        $data['key'] = $this->authKey('shop');
        return view('front.shop.index', $data);
    }
    public function pageData(Request $request)
    {
        $m = new search;
        $db = DB::table('shop');
        $m->setSearch($db, $request);
        $db->where(['shop.valid'=>1]);
        $data['page'] = $m->setPage($db, $request);
        $data['data'] = $db->select('shop.id', 'shop.title', 'shop.shop_image', 'shop.sort', 'shop.update_at', 'shop_type.title as type','shop.contact')
            ->leftJoin('shop_type', 'shop_type.id', '=', 'shop.type_id')
            ->orderBy('shop.update_at', 'desc')
            ->get();
        foreach ($data['data'] as $key => &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return response()->json($data, 200);
    }
    public function add()
    {
        $data['action'] = 'add';
        $data['shopType'] = $this->getAllshopType();
        return view('front.shop.add',$data);
    }
    public function edit($id, $act)
    {
        $data['data'] = shop::find($id);
        $data['shopType'] = $this->getAllshopType();
        $data['action'] = $act;
        return view('front.shop.add', $data);
    }
    private function getAllshopType()
    {
        $tmp = DB::table('shop_type')->select('id', 'title')->get();
        return $tmp;
    }
    private $rule = [
        'shop' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入标题!'],
            'type_id' => ['name' => 'type_id', 'preg' => ':number', 'notice' => '请选择店铺类型!'],
            'shop_image' => ['name' => 'shop_image', 'preg' => ':image', 'notice' => '请上传店铺首图'],
            'second_title' => ['name' => 'second_title', 'preg' => ':notnull', 'notice' => '请输入副标题'],
            'bg_image' => ['name' => 'bg_image', 'preg' => ':image', 'notice' => '请上传背景图片'],
            'stat' => ['name' => 'stat', 'preg' => ':number', 'notice' => '请选择星星数量'],
            'sale_num' => ['name' => 'sale_num', 'preg' => ':number', 'notice' => '请输入商品数量'],
            'collect_num' => ['name' => 'collect_num', 'preg' => ':number', 'notice' => '请输入收藏数量'],
            'sort' => ['name' => 'sort', 'preg' => ':number', 'notice' => '请输入排序'],
            'phone' => ['name' => 'phone', 'preg' => ':tel', 'notice' => '请输入正确的联系方式', 'not_null' => false],
        ],
    ];
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['type_id'] = $request->post('type_id');
        $data['shop_image'] = $request->post('shop_image');
        $data['second_title'] = $request->post('second_title');
        $data['bg_image'] = $request->post('bg_image');
        $data['stat'] = $request->post('stat');
        $data['sale_num'] = $request->post('sale_num');
        $data['collect_num'] = $request->post('collect_num');
        $data['detail'] = $request->post('detail');
        $data['sort'] = $request->post('sort');
        $data['contact'] = $request->post('contact');
        $data['phone'] = $request->post('phone');
        $data['address'] = $request->post('address');
        $data['remark'] = $request->post('remark');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'shop');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $data['insert_at'] = time();
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['update_at'] = $data['insert_at'];
                $id = shop::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $data['update_at'] = time();
                shop::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    public function deleteData($id)
    {
        shop::destroy($id);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function type()
    {
        return view('front.shop.type');
    }
    public function typeData()
    {
        $data = DB::table('shop_type')->get();
        foreach ($data as $key => $v) {
            $v->insert_at = date('Y-m-d H:i:s', $v->insert_at);
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '获取成功', 'data' => $data]);
    }
    public function typeSave(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['insert_at'] = time();
        $data['update_at'] = time();
        DB::table('shop_type')->insert($data);
        return response()->json(['result' => 'SUCCESS', 'msg' => '添加成功']);
    }
    public function deleteShopType($id)
    {
        DB::table('shop_type')->where('id', $id)->delete();
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
