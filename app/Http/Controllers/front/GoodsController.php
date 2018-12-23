<?php
namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\models\front\shop;
use App\models\front\goods;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\FormCheck;
use App\libraries\classes\search;
use App\models\front\tag;
use App\models\front\classify;

class GoodsController extends Controller
{
    
    public function index()
    {
        $data['title'] = '商品管理';
        $data['key'] = $this->authKey('goods');
        $data['shop'] = shop::allShop();
        $data['classify'] = $this->allShopTypeData();
        return view('front.goods.index', $data);
    }
    public function allShopTypeData()
    {
        $classifyObj = new classify;
        return $classifyObj->allData();
    }
    public function pageData(Request $request)
    {
        $m = new search;
        $db = DB::table('goods');
        $db->where(['goods.valid'=>1]);
        $m->setSearch($db, $request);
        $data['page'] = $m->setPage($db, $request);
        $data['data'] = $db->select('goods.id', 'goods.title', 'goods.first_img', 'goods.serial_num', 'goods.update_at', 'goods_classify.title as type','goods.buy_price','shop.title as shop_name')
            ->leftJoin('goods_classify', 'goods_classify.id', '=', 'goods.type_id')
            ->leftJoin('shop','goods.shop_id','=','shop.id')
            ->orderBy('goods.update_at', 'desc')
            ->get();
        foreach ($data['data'] as $key => &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return response()->json($data, 200);
    }
    public function add()
    {
        $data['action'] = 'add';
        $data['shop'] = shop::allShop();
        $data['classify'] = $this->allShopTypeData();
        $data['tag'] = tag::allTag();
        return view('front.goods.add', $data);
    }
    public function edit($id, $act)
    {
        $data['action'] = 'add';
        $data['shop'] = shop::allShop();
        $data['classify'] = $this->allShopTypeData();
        $data['tag'] = tag::allTag();
        $data['action'] = $act;
        $tmp = goods::find($id);
        $data['data'] = $tmp;
        return view('front.goods.add', $data);
    }
    private $rule = [
        'goods_form' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入商品标题!'],
            'shop_id' => ['name' => 'shop_id', 'preg' => ':number', 'notice' => '请选择商品所属商家!'],
            'type_id' => ['name' => 'type_id', 'preg' => ':number', 'notice' => '请选择商品所属分类!'],
            'serial_num' => ['name' => 'serial_num', 'preg' => ':number', 'notice' => '请输入商品序列号'],
            'first_img' => ['name' => 'first_img', 'preg' => ':image', 'notice' => '请上传新闻首图'],
            'wholesale' => ['name' => 'wholesale', 'preg' => ':number', 'notice' => '请选择商品批发起始数量'],
            'weight' => ['name' => 'weight', 'preg' => ':number', 'notice' => '请输入商品重量'],
            'unit' => ['name' => 'unit', 'preg' => ':notnull', 'notice' => '请选择商品单位'],
            'buy_price' => ['name' => 'buy_price', 'preg' => ':float', 'notice' => '请输入商品购买价格'],
            'sale_price' => ['name' => 'sale_price', 'preg' => ':float', 'notice' => '请输入商品原价'],
            'producter' => ['name' => 'producter', 'preg' => ':notnull', 'notice' => '请输入商品产地'],
            'content' => ['name' => 'content', 'preg' => ':notnull', 'notice' => '请输入商品详情'],
            'see_num' => ['name' => 'see_num', 'preg' => ':number', 'notice' => '请输入浏览数量'],
            'done_num' => ['name' => 'done_num', 'preg' => ':number', 'notice' => '请输入商品成交数量'],
            'consult_num' => ['name' => 'consult_num', 'preg' => ':number', 'notice' => '请输入咨询数量'],
            'sale_num' => ['name' => 'sale_num', 'preg' => ':number', 'notice' => '请输入销售数量'],            
        ],
    ];
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['shop_id'] = $request->post('shop_id');
        $data['type_id'] = $request->post('type_id');
        $data['serial_num'] = $request->post('serial_num');
        $data['wholesale'] = $request->post('wholesale');
        $data['weight'] = $request->post('weight');
        $data['first_img'] = $request->post('first_img');
        $data['unit'] = $request->post('unit');
        $data['buy_price'] = $request->post('buy_price');
        $data['sort'] = $request->post('sort');
        $data['tags'] = $request->post('goods_tag');
        $data['notice'] = $request->post('notice');
        $data['producter'] = $request->post('producter');
        $data['content'] = $request->post('content');
        $data['see_num'] = $request->post('see_num');
        $data['done_num'] = $request->post('done_num');
        $data['consult_num'] = $request->post('consult_num');
        $data['sale_num'] = $request->post('sale_num');
        $data['sale_price'] = $request->post('sale_price');
        $formObj = load_class('FormCheck', $this->rule);
        $checkResult = $formObj->checkFrom($data, 'goods_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $images = $request->post('images');
        $data['images'] = json_encode(empty($images) ? [] : $images);
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['insert_at'] = $data['update_at'] = time();
                $id = goods::insertGetId($data);
                $this->editTags($id, $data['tags']);
                break;
            case 'edit':
                $id = $request->post('id');
                $data['update_at'] = time();
                goods::where('id', $id)->update($data);
                $this->editTags($id, $data['tags']);
                break;
            default:
            # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $id]);
    }
    private function editTags($id, $tag)
    {
        $tmp = json_decode($tag, true);
        DB::table('goods_tag_val')->where('goods_id', $id)->delete();
        if (empty($tmp)) {
            return;
        }
        $data = [];
        foreach ($tmp as $key => $v) {
            $data[] = ['goods_id' => $id, 'tag_id' => $v];
        }
        DB::table('goods_tag_val')->insert($data);
    }
    public function deleteData($id)
    {
        goods::where('id', $id)->update(['valid' => 0]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function type()
    {
        return view('front.goods.type');
    }
    public function typeData()
    {
        $data = DB::table('goods_type')->get();
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
        $data['icon'] = $request->post('icon');
        DB::table('goods_type')->insert($data);
        return response()->json(['result' => 'SUCCESS', 'msg' => '添加成功']);
    }
    public function deleteGoodsType($id)
    {
        DB::table('goods_type')->where('id', $id)->delete();
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
