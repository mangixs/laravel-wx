<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\admin\shop;
use DB;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $rule = [
        'shop_form' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入商家名称!'],
            'tel' => ['name' => 'tel', 'preg' => ':tel', 'notice' => '请输入电话号码'],
            'contact' => ['name' => 'contact', 'preg' => ':notnull', 'notice' => '请输入联系人'],
            'login_name' => ['name' => 'login_name', 'preg' => ':login_name', 'notice' => '请输入商家后台登录账号'],
            'logo' => ['name' => 'logo', 'preg' => ':image', 'notice' => '请上传图片'],
        ],
    ];
    public function index()
    {
        $data['title'] = '商家管理';
        $data['key'] = $this->authKey('shop');
        return view('admin.shop.index', $data);
    }
    public function pageData(Request $request)
    {
        $data = (new shop())->pageData($request);
        return response()->json($data);
    }
    public function add()
    {
        $data['action'] = 'add';
        return view('admin.shop.add', $data);
    }
    public function edit($id, $act)
    {
        $data['data'] = shop::find($id);
        $data['action'] = $act;
        return view('admin.shop.add', $data);
    }
    public function deleteShop($id)
    {
        shop::where('id', $id)->update(['valid' => 0]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['tel'] = $request->post('tel');
        $data['contact'] = $request->post('contact');
        $data['numbered'] = $request->post('numbered');
        $data['login_name'] = $request->post('login_name');
        $data['logo'] = $request->post('logo');
        $data['address'] = $request->post('address');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'shop_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['pwd'] = md5('shop2018');
                $id = shop::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $data['pwd'] = md5($request->post('newpwd'));
                shop::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
}
