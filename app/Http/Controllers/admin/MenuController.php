<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\libraries\classes\FormCheck;
use App\models\admin\menu;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\search;

class MenuController extends Controller
{
    private $rule = [
        'menu_form' => [
            'named' => ['name' => 'named', 'preg' => ':notnull', 'notice' => '请输入名称'],
            'url' => ['name' => 'url', 'preg' => '/[a-z|A-Z|\/]+/', 'notice' => '请输入功能名称', 'not_null' => false],
            'screen_auth' => ['name' => 'screen_auth', 'preg' => ':notnull', 'notice' => '请设置权限'],
            'sort' => ['name' => 'sort', 'preg' => ':number', 'notice' => '请输入排序', 'not_null' => false],
            'parent' => ['name' => 'parent', 'preg' => ':number', 'notice' => '请输入选择菜单父级'],
            'icon' => ['name' => 'icon', 'preg' => ':notnull', 'notice' => '请上传图标', 'not_null' => false],
        ],
    ];
    public function index()
    {
        $data['title'] = '菜单管理';
        $data['key'] = $this->authKey('menu');
        return view('admin.menu.index', $data);
    }
    public function pageData(Request $request)
    {
        $m=new search;
        $db=DB::table('menu');
        $m->setSearch($db,$request);
        $data['page']=$m->setPage($db,$request);
        $data['data']=$db->where('parent',0)->select('id','named','url','sort','level','parent')->get();
        return response()->json($data);
    }
    public function childMenu(Request $request)
    {
        $pid = $request->input('pid');
        $ret = (new menu())->getChildData($pid);
        if ($ret->isEmpty()) {
            return response()->json(['result' => 'EMPTY', 'msg' => '无子菜单数据', 'pid' => $pid]);
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '获取成功', 'data' => $ret, 'pid' => $pid]);
    }
    public function add($id)
    {
        $data['action'] = 'add';
        $data['all'] = $this->allMenu();
        $data['func'] = $this->funcAuth();
        $data['pid'] = $id;
        return view('admin.menu.add', $data);
    }
    protected function allMenu()
    {
        $res = menu::get();
        $data = [];
        foreach ($res as $k => $v) {
            $data[$v->parent][$v->id] = $v;
        }
        $tree = [];
        $this->treeMenu($data, 0, $tree);
        return $tree;
    }
    private function treeMenu(&$data, $pid, &$tree)
    {
        if (isset($data[$pid])) {
            foreach ($data[$pid] as $k => $v) {
                $tree[$k] = $v;
                $this->treeMenu($data, $k, $tree);
            }
        }
    }
    private function funcAuth()
    {
        $func = $this->func_all();
        $auth = $this->auth_all();
        $tmp = [];
        foreach ($auth as $v) {
            $tmp[$v->func_key][] = $v;
        }
        $ret = [];
        foreach ($func as $v) {
            $ret[$v->key] = $v;
            if (array_key_exists($v->key, $tmp)) {
                $ret[$v->key]->auth = $tmp[$v->key];
            } else {
                $ret[$v->key]->auth = [];
            }
        }
        return $ret;
    }
    private function func_all()
    {
        return DB::table('background_func')->get();
    }
    private function auth_all()
    {
        return DB::table('func_auth')->get();
    }
    public function edit($id, $act)
    {
        $data['data'] = menu::find($id);
        $data['action'] = $act;
        $data['all'] = $this->allMenu();
        $data['func'] = $this->funcAuth();
        return view('admin.menu.add', $data);
    }
    public function save(Request $request)
    {
        $data['named'] = $request->input('named');
        $data['url'] = $request->input('url');
        $data['screen_auth'] = $request->input('screen_auth');
        $data['sort'] = $request->input('sort');
        $data['parent'] = $request->input('parent');
        $data['icon'] = $request->input('icon');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'menu_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $id = $this->addMenu($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $this->editMenu($id, $data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    private function addMenu($data)
    {
        if ($data['parent'] == 0) {
            $data['level'] = 0;
            $id = menu::insertGetId($data);
            return $id;
        } else {
            $parent = menu::where('id', $data['parent'])->select('level')->first();
            $data['level'] = (int) $parent->level + 1;
            $id = menu::insertGetId($data);
            return $id;
        }
    }
    private function editMenu($id, $data)
    {
        if ($data['parent'] == 0) {
            $data['level'] = 0;
            menu::where('id', $id)->update($data);
        } else {
            $parent = menu::where('id', $data['parent'])->select('level')->first();
            $data['level'] = (int) $parent->level + 1;
            menu::where('id', $id)->update($data);
        }
    }
    public function deleteMenu($id)
    {
        $res = menu::where('parent', $id)->select('id', 'named')->get();
        if (isset($res->id)) {
            return response()->json(['result' => 'ERROR', 'msg' => '存在子菜单,不可删除']);
        }
        menu::destroy($id);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
