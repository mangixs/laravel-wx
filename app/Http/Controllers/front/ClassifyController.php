<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\front\classify;
use DB;
use App\libraries\classes\FormCheck;

class ClassifyController extends Controller
{
    private $rule = [
        'classify_form' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入名称'],
            'sort' => ['name' => 'sort', 'preg' => ':number', 'notice' => '请输入排序', 'not_null' => false],
            'parent' => ['name' => 'parent', 'preg' => ':number', 'notice' => '请输入选择菜单父级'],
            'icon' => ['name' => 'icon', 'preg' => ':notnull', 'notice' => '请上传图标', 'not_null' => false],
        ],
    ];
    public function index()
    {
        $data['title'] = '商品分类管理';
        $data['key'] = $this->authKey('classify');
        return view('front.classify.index', $data);
    }
    public function pageData(Request $request)
    {
        $data = (new classify)->pageData($request);
        return response()->json($data);
    }
    public function add($id)
    {
        $obj = new classify();
        $data['action'] = 'add';
        $data['pid'] = $id;
        $data['all'] = $obj->allData();
        return view('front.classify.add', $data);
    }
    public function edit($id, $act)
    {
        $obj = new classify();
        $data['data'] = classify::find($id);
        $data['action'] = $act;
        $data['all'] = $obj->allData();
        return view('front.classify.add', $data);
    }
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['sort'] = $request->post('sort');
        $data['parent'] = $request->post('parent');
        $data['icon'] = $request->post('icon');
        $formObj =  new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'classify_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $data['update_at'] = time();
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['insert_at'] = time();
                $id = $this->addClassify($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $this->editClassify($id, $data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $id]);
    }
    private function addClassify($data)
    {
        if ($data['parent'] == 0) {
            $data['level'] = 0;
            $id = classify::insertGetId($data);
            return $id;
        } else {
            $parent = DB::table('goods_classify')->where('id', $data['parent'])->select('level')->first();
            $data['level'] = (int) $parent->level + 1;
            $id = classify::insertGetId($data);
            return $id;
        }
    }
    private function editClassify($id, $data)
    {
        if ($data['parent'] == 0) {
            $data['level'] = 0;
            classify::where('id', $id)->update($data);
        } else {
            $parent = DB::table('goods_classify')->where('id', $data['parent'])->select('level')->first();
            $data['level'] = (int) $parent->level + 1;
            classify::where('id', $id)->update($data);
        }
    }
    public function deleteClassify($id)
    {
        $res = DB::table('goods_classify')->where('parent', $id)->select('id', 'title')->first();
        if (isset($res->id)) {
            return response()->json(['result' => 'ERROR', 'msg' => '存在子分类,不可删除']);
        }
        classify::destroy($id);
        $this->staffLog(3, $id, '商品分类', DB::getQueryLog());
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function childData(Request $request)
    {
        $pid = $request->input('pid');
        $ret = classify::where('parent', $pid)->select('id', 'title', 'sort', 'level', 'parent', 'icon')->get();
        if ($ret->isEmpty()) {
            return response()->json(['result' => 'EMPTY', 'msg' => '无子菜单数据', 'pid' => $pid]);
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '获取成功', 'data' => $ret, 'pid' => $pid]);
    }
}
