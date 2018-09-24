<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

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
    public function uploadImage(Request $request)
    {
        $img = $request->file('img');
        if (empty($img)) {
            return reponse()->json(['result' => 'ERROR', 'msg' => '图片为空']);
        }
        $ext = $img->getClientOriginalExtension();
        $extArr = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($ext, $extArr)) {
            return response()->json(['result' => 'ERROR', 'msg' => '图片类型错误']);
        }
        $size = $img->getClientSize();
        if ((int) $size > 2 * 1024 * 1024) {
            return response()->json(['result' => 'ERROR', 'msg' => '图片大小错误']);
        }
        $folder = date('Ymd');
        if (!Storage::disk('public')->exists($folder)) {
            Storage::makeDirectory($folder);
        }
        $path = $request->file('img')->store($folder);
        if ($path) {
            return response()->json(['result' => 'SUCCESS', 'msg' => '上传成功', 'path' => '/upload/' . $path]);
        } else {
            return response()->json(['result' => 'ERROR', 'msg' => '上传文件失败', 'data' => $path]);
        }
    }
}
