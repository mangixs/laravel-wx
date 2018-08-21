<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\libraries\classes\FormCheck;
use App\models\admin\func;
use DB;
use Illuminate\Http\Request;

class FuncController extends Controller
{
    private $rule = [
        'func_form' => [
            'key' => ['name' => 'key', 'preg' => ':en_no_space', 'notice' => '请输入正确的键名!'],
            'func_name' => ['name' => 'func_name', 'preg' => ':notnull', 'notice' => '名称不能为空'],
        ],
    ];
    public function index()
    {
        $data['title'] = '功能管理';
        $data['key'] = $this->authKey('func');
        return view('admin.func.index', $data);
    }
    public function pageData(Request $request)
    {
        $data = (new func())->pageData($request);
        return response()->json($data);
    }
    public function add()
    {
        $data['action'] = 'add';
        return view('admin.func.add', $data);
    }
    public function edit($id, $act)
    {
        $data['data'] = (new func())->single($id);
        $data['action'] = $act;
        return view('admin.func.add', $data);
    }
    public function save(Request $request)
    {
        $data['key'] = $request->post('keys');
        $data['func_name'] = $request->post('func_name');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'func_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                func::insert($data);
                break;
            case 'edit':
                func::where('key', $data['key'])->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $data['key']]);
    }
    public function deleteKey($id)
    {
        func::destroy($id);
        DB::table('func_auth')->where('func_key',$id)->delete();
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function set($key)
    {
        $data['data'] = DB::table('background_func')->where('key', $key)->select('key', 'func_name')->first();
        $data['set'] = DB::table('func_auth')->where('func_key', $key)->get();
        return view('admin.func.set', $data);
    }
    public function setSave(Request $request)
    {
        $keys = $request->input('key');
        $names = $request->input('extendname');
        $func_key = $request->input('extendkey');
        $data = [];
        if (!empty($names)) {
            foreach ($func_key as $i => $key) {
                $data[] = ['key' => $key, 'func_key' => $keys, 'auth_name' => $names[$i]];
            }
            DB::table('func_auth')->where('func_key', $keys)->delete();
            DB::table('func_auth')->insert($data);
        } else {
            DB::table('func_auth')->where('func_key', $keys)->delete();
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '操作成功']);
    }
}
