<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\front\nav;
use DB;
use App\libraries\classes\FormCheck;
use App\libraries\classes\search;

class NavController extends Controller
{
    private $rule = [
        'nav' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入标题!'],
            'type_id' => ['name' => 'type_id', 'preg' => ':number', 'notice' => '请选择导航分类!'],
            'url' => ['name' => 'url', 'preg' => ':notnull', 'notice' => '请输入正确的链接!', 'not_null' => false],
            'icon' => ['name' => 'icon', 'preg' => ':image', 'notice' => '请选择展示位置'],
        ],
    ];
    public function index()
    {
        $data['title'] = '导航管理';
        $data['key'] = $this->authKey('nav');
        return view('front.nav.index', $data);
    }
    public function pageData(Request $request)
    {
        $m = new search;
        $db = DB::table('nav');
        $m->setSearch($db, $request);
        $db->where(['nav.valid'=>1]);
        $data['page'] = $m->setPage($db, $request);
        $data['data'] = $db->select('nav.id', 'nav.title', 'nav.icon', 'nav.sort', 'nav.update_at', 'nav_type.title as type','nav.url')
            ->leftJoin('nav_type', 'nav_type.id', '=', 'nav.type_id')
            ->orderBy('nav.update_at', 'desc')
            ->get();
        foreach ($data['data'] as $key => &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return response()->json($data, 200);
    }
    public function add()
    {
        $data['action'] = 'add';
        $data['navType'] = $this->getAllNavType();
        return view('front.nav.add',$data);
    }
    public function edit($id, $act)
    {
        $data['data'] = nav::find($id);
        $data['navType'] = $this->getAllNavType();
        $data['action'] = $act;
        return view('front.nav.add', $data);
    }
    private function getAllNavType()
    {
        $tmp = DB::table('nav_type')->select('id', 'title')->get();
        return $tmp;
    }
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['type_id'] = $request->post('type_id');
        $data['url'] = $request->post('url');
        $data['sort'] = $request->post('sort');
        $data['icon'] = $request->post('icon');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'nav');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $data['insert_at'] = time();
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['update_at'] = $data['insert_at'];
                $id = nav::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $data['update_at'] = time();
                nav::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    public function deletenav($id)
    {
        nav::destroy($id);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function type()
    {
        return view('front.nav.type');
    }
    public function typeData()
    {
        $data = DB::table('nav_type')->get();
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
        DB::table('nav_type')->insert($data);
        return response()->json(['result' => 'SUCCESS', 'msg' => '添加成功']);
    }
    public function deletenavType($id)
    {
        DB::table('nav_type')->where('id', $id)->delete();
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
