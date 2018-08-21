<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\admin\staff;
use DB;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{

    public function index()
    {
        $data['title'] = '后台主页';
        $userinfo = unserialize(session('staff_object_session'));
        $data['menu'] = $this->createMenu($userinfo['key']);
        $data['named'] = $userinfo['true_name'];
        $data['img'] = $userinfo['header_img'];
        return view('public.home', $data);
    }
    public function loginOut()
    {
        header("Cache-Control:no-cache,must-revalidate,no-store");
        header("Pragma:no-cache");
        header("Expires:-1");
        $id = $this->staffId();
        Session::forget('staff_object_session');
        return redirect()->action('LoginController@login');
    }
    public function pwd()
    {
        return view('login.pwd');
    }
    public function save(Request $request)
    {
        $old = $request->input('old');
        $pwd = $request->input('pwd');
        $newpwd = $request->input('newpwd');
        if (!preg_match("/^[\w|\.]{5,}$/", $old)) {
            return response()->json(['result' => 'ERROR', 'msg' => '旧密码格式错误']);
        }
        if (!preg_match("/^[\w|\.]{5,}$/", $pwd)) {
            return response()->json(['result' => 'ERROR', 'msg' => '新密码格式错误']);
        }
        if ($pwd !== $newpwd) {
            return response()->json(['result' => 'ERROR', 'msg' => '新密码不一致']);
        }
        $id = $this->staffId();
        staff::where('id', $id)->update(['pwd' => md5($pwd)]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '更新成功']);
    }
    private function createMenu($func_data)
    {
        $menu_data = $this->menuData();
        foreach ($func_data as $k => $v) {
            if (empty($res_func[$v['func_key']])) {
                $res_func[$v['func_key']] = [
                    'func_key' => $v['func_key'],
                    'auth_key' => [],
                ];
            }
            if (!in_array($v['auth_key'], $res_func[$v['func_key']]['auth_key'])) {
                $res_func[$v['func_key']]['auth_key'][] = $v['auth_key'];
            }
        }
        $key_name = array_keys($res_func);
        foreach ($menu_data as $w => $d) {
            if (in_array($w, $key_name)) {
                $res[] = [
                    'menu_id' => $d['menu_id'],
                    'key_val' => $d['key_val'],
                    'func_val' => $w,
                ];
            }
        }
        $ret = [];
        foreach ($res as $e => $t) {
            foreach ($t['menu_id'] as $c => $r) {
                if (!in_array($r, $ret)) {
                    $ret[] = $r;
                }
            }
        }
        ksort($ret);
        $rets = DB::table('menu')->select('id', 'url', 'named', 'icon', 'level', 'parent')->whereIn('id', $ret)->orderBy('sort', 'asc')->get()->map(function ($v) {
            return (array) $v;
        })->toArray();
        $parentList = [];
        foreach ($rets as $menu) {
            $parentList[$menu['parent']][] = $menu;
        }
        $tree = $this->createTree($parentList, 0);
        $menuList = $this->createList($tree);
        return $menuList;
    }
    private function createList($tree)
    {
        ob_start();
        echo '<ul class="menu-ul">';
        foreach ($tree as $k => $v) {
            echo '<li class="parent-li">';
            echo '<a href="javascript:;" class="parent-a">';
            if (!empty($v['icon'])) {
                echo '<img src="' . $v['icon'] . '" class="parent-img">';
                echo $v['named'];
            } else {
                echo '<span class="parent-span">' . $v['named'] . '</span>';
            }
            echo '<span class="arrow"></span>';
            echo '</a>';
            if (!empty($v['children'])) {
                echo '<ul class="child-ul">';
                foreach ($v['children'] as $c => $d) {
                    echo '<li class="child-li">';
                    echo '<a href="' . $d['url'] . '" target="list" class="child-a" >';
                    if (!empty($d['icon'])) {
                        echo '<img src="' . $d['icon'] . '" class="child-img">';
                        echo '<span class="child-span" >' . $d['named'] . '</span>';
                    } else {
                        echo '<span class="child-span span-text">' . $d['named'] . '</span>';
                    }
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
        $ret = ob_get_contents();
        ob_clean();
        return $ret;
    }
    private function createTree(&$parentList, $pos)
    {
        $ret = [];
        foreach ($parentList[$pos] as $k => $v) {
            $ret[$v['id']] = $v;
            if (isset($parentList[$v['id']])) {
                $ret[$v['id']]['children'] = $this->createTree($parentList, $v['id']);
            }
        }
        return $ret;
    }
    private function menuData()
    {
        $data = DB::table('menu')->select('id', 'screen_auth')->get()->map(function ($v) {
            return (array) $v;
        })->toArray();
        foreach ($data as $k => $v) {
            $tmp = json_decode($v['screen_auth'], true);
            foreach ($tmp as $e => $c) {
                if (empty($res[$e])) {
                    $res[$e] = [
                        'menu_id' => [],
                        'key_val' => [],
                    ];
                }
                if (!in_array($v['id'], $res[$e]['menu_id'])) {
                    $res[$e]['menu_id'][] = $v['id'];
                }
                if (!in_array($c[0], $res[$e]['key_val'])) {
                    $res[$e]['key_val'][] = $c[0];
                }
            }
        }
        return $res;
    }
}
