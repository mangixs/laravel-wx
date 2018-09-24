<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\libraries\classes\Code;
use App\models\login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    public function captcha(Request $request)
    {
        $randStr = randStr(4);
        session_start();
        $_SESSION['mini_login_captcha'] = $randStr;
        $code = new Code(['code' => $randStr]);
        return $code->show();
    }
    public function sub(Request $request)
    {
        $url = action('admin\\HomeController@index');
        $username = $request->post('username');
        $pwd = $request->post('password');
        $captcha = $request->post('captcha');
        $num = Redis::get($username . 'errorNumber');
        if ((int) $num >= 5) {
            return response()->json(['result' => 'ERROR', 'msg' => '错误次数过多，稍后再试']);
        }
        session_start();
        $serverCaptcha = $_SESSION['mini_login_captcha'];
        if (strtoupper($captcha) != strtoupper($serverCaptcha)) {
            return response()->json(['result' => 'ERROR', 'msg' => '验证码错误']);
        }
        if (!preg_match("/^[\w|_]{4,16}$/", $username)) {
            return response()->json(['result' => 'ERROR', 'msg' => '用户名错误']);
        }
        if (!preg_match("/^[\w|_]{4,16}$/", $pwd)) {
            return response()->json(['result' => 'ERROR', 'msg' => '密码错误']);
        }
        $db = new login();
        $ret = $db->checkLogin($username, $pwd);
        if (!isset($ret->id)) {
            if (empty($num)) {
                Redis::setex($username . 'errorNumber', 300, 1);
            } else {
                Redis::setex($username . 'errorNumber', 300, (int) $num + 1);
            }
            return response()->json(['result' => 'LOGIN_ERROR', 'msg' => '用户名密码错误']);
        }
        unset($ret['pwd']);
        $hasJob = $db->getStaffJob($ret['id']);
        if ($hasJob->isEmpty()) {
            return response()->json(['result' => 'ERROR', 'msg' => '该用户无后台管理权限']);
        }
        $jobId = [];
        foreach ($hasJob as $v) {
            $jobId[] = $v->job_id;
        }
        $ret['key'] = $this->getKey($jobId);
        session(['staff_object_session' => serialize($ret)]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '登录成功', 'url' => $url]);
    }
}
