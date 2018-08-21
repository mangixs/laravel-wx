<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getKey($id)
    {
        $data = DB::table('admin_job_auth')->select('func_key', 'auth_key')->distinct()->whereIn('admin_job_id', $id)->get();
        $res_func = [];
        foreach ($data as $k => $v) {
            if (empty($res_func[$v->func_key])) {
                $res_func[$v->func_key] = [
                    'func_key' => $v->func_key,
                    'auth_key' => [],
                ];
            }
            if (!in_array($v->auth_key, $res_func[$v->func_key]['auth_key'])) {
                $res_func[$v->func_key]['auth_key'][] = $v->auth_key;
            }
        }
        return $res_func;
    }
    public function staffId()
    {
        $data = unserialize(session('staff_object_session'));
        return $data['id'];
    }
    public function authKey($key)
    {
        $data = unserialize(session('staff_object_session'));
        return $data['key'][$key];
    }
}
