<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\admin\staff;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\FormCheck;
use App\libraries\classes\search;

class StaffController extends Controller
{
    private $rule = [
        'staff_form' => [
            'login_name' => ['name' => 'login_name', 'preg' => '/^[\w|_]{4,}$/', 'notice' => '请输入正确的登录名!'],
            'staff_num' => ['name' => 'staff_num', 'preg' => ':number', 'notice' => '请输入正确的用户编号!'],
            'true_name' => ['name' => 'true_name', 'preg' => ':ch', 'notice' => '请输入正确的用户名!', 'not_null' => false],
            'sex' => ['name' => 'sex', 'preg' => '/^[1|2]{1}$/', 'notice' => '请选择用户性别', 'not_null' => false],
            'header_img' => ['name' => 'header_img', 'preg' => ':notnull', 'notice' => '请上传用户头像', 'not_null' => false],
            'newpwd' => ['name' => 'newpwd', 'preg' => '/^[\w]{4,16}/', 'notice' => '用户密码错误', 'not_null' => false],
        ],
    ];
    public function index()
    {
        $data['title'] = '管理员管理';
        $data['key'] = $this->authKey('staff');
        return view('admin.staff.index', $data);
    }
    public function pageData(Request $request)
    {
        $m=new search;
		$db=DB::table('staff');
		$m->setSearch($db,$request);
		$data['page']=$m->setPage($db,$request);
		$data['data']=$db->select('id','login_name','staff_num','sex','true_name')->get();
		return response()->json($data);
    }
    public function add()
    {
        $data['action'] = 'add';
        return view('admin.staff.add', $data);
    }
    public function edit($id, $act)
    {
        $data['data'] = staff::find($id);
        $data['action'] = $act;
        return view('admin.staff.add', $data);
    }
    public function save(Request $request)
    {
        $data['login_name'] = $request->post('login_name');
        $data['staff_num'] = $request->post('staff_num');
        $data['true_name'] = $request->post('true_name');
        $data['sex'] = $request->post('sex');
        $data['header_img'] = $request->post('header_img');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'staff_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $data['update_at'] = time();
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['created_at'] = $data['update_at'];
                $data['pwd'] = md5('123@456');
                $id = staff::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $pwd = $request->post('newpwd');
                if(!empty($pwd)){
                    $data['pwd'] = md5($pwd);
                }
                staff::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    public function deleteStaff($id)
    {
        staff::destroy($id);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function set($id)
    {
        $data['staff_id'] = $id;
        $data['data'] = DB::table('admin_job')->where('vaild', 1)->select('id', 'job_name')->get();
        $data['has'] = $this->staffJob($id);
        return view('admin.staff.set', $data);
    }
    private function staffJob($id)
    {
        $ret = DB::table('staff_job')->where('staff_id', $id)->select('job_id')->get();
        $data = [];
        foreach ($ret as $key => $v) {
            $data[] = $v->job_id;
        }
        return $data;
    }
    public function setSave(Request $request)
    {
        $staff_id = $request->input('staff_id');
        $job_id = $request->input('job_id');
        $set = $request->input('set') === 'true' ? true : false;
        if (empty($staff_id) and empty($job_id) and !is_numeric($staff_id) and !is_numeric($job_id) and !is_bool($set)) {
            return response()->json(['result' => 'ERROR', 'msg' => '参数错误']);
        }
        DB::table('staff_job')->where('staff_id', $staff_id)->where('job_id', $job_id)->delete();
        if ($set) {
            DB::table('staff_job')->insert(['staff_id' => $staff_id, 'job_id' => $job_id]);
        }
        $ret = $this->staffJob($staff_id);
        DB::table('staff')->where('id', $staff_id)->update(['job' => json_encode($ret)]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '设置成功']);
    }
}
