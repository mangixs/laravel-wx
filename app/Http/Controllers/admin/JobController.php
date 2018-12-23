<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\libraries\classes\FormCheck;
use App\models\admin\job;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\search;

class JobController extends Controller
{
    private $rule = [
        'job_form' => [
            'job_name' => ['name' => 'job_name', 'preg' => ':ch', 'notice' => '请输入正确的职位名!'],
        ],
    ];
    public function index()
    {
        $data['title'] = '职位管理';
        $data['key'] = $this->authKey('job');
        return view('admin.job.index', $data);
    }
    public function pageData(Request $request)
    {
        $m=new search;
		$db=DB::table('admin_job');
		$m->setSearch($db,$request);
		$data['page']=$m->setPage($db,$request);
		$data['data']=$db->select('id','job_name')->get();
		return response()->json($data);
    }
    public function add()
    {
        $data['action'] = 'add';
        return view('admin.job.add', $data);
    }
    public function edit($id, $act)
    {
        $data['data'] = job::find($id);
        $data['action'] = $act;
        return view('admin.job.add', $data);
    }
    public function save(Request $request)
    {
        $data['job_name'] = $request->post('job_name');
        $data['explain'] = $request->post('explain');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'job_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $id = job::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                job::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    public function deleteJob($id)
    {
        job::destroy($id);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function set($id)
    {
        $data['func'] = $this->funcAuth();
        $data['has'] = $this->hasAuth($id);
        $data['admin_job_id'] = $id;
        return view('admin.job.set', $data);
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
    private function hasAuth($id)
    {
        $res = DB::table('admin_job_auth')->where('admin_job_id', $id)->get();
        $ret = [];
        foreach ($res as $v) {
            $ret[$v->func_key][] = $v->auth_key;
        }
        return $ret;
    }
    public function setSave(Request $request)
    {
        $data['admin_job_id'] = $request->input('admin_job_id');
        $data['auth_key'] = $request->input('auth_key');
        $data['func_key'] = $request->input('func_key');
        $ret = $this->auth($data);
        if ($ret) {
            return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
        } else {
            return response()->json(['result' => 'SUCCESS', 'msg' => '添加成功']);
        }
    }
    private function auth($data)
    {
        $db = DB::table('admin_job_auth');
        $cou = $db->where('admin_job_id', $data['admin_job_id'])->where('auth_key', $data['auth_key'])->where('func_key', $data['func_key'])->count();
        if ($cou > 0) {
            $db->where('admin_job_id', $data['admin_job_id'])->where('auth_key', $data['auth_key'])->where('func_key', $data['func_key'])->delete();
            return true;
        } else {
            $db->insert($data);
            return false;
        }
    }
}
