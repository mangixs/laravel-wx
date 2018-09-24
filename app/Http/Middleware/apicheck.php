<?php

namespace App\Http\Middleware;

use App\models\user;
use Closure;
use Illuminate\Http\Request;

class apicheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();
        $timeStamp = $params['timeStamp'];
        if (time() >= (strtotime($timeStamp) + 600)) {
            return response()->json(['result' => 'ERROR', 'msg' => '请求超时']);
        }
        $sign = $params['sign'];
        if (empty($sign)) {
            return response()->json(['result' => 'ERROR', 'msg' => '参数错误']);
        }
        unset($params['sign']);
        ksort($params);
        $sign = http_build_query($params);
        $sign = $sign . '&authkey=' . getenv('wxAppid');
        $sign = strtoupper(md5($sign));
        if ($sign !== $sign) {
            return response()->json(['result' => 'ERROR', 'msg' => '签名错误']);
        }
        return $next($request);
    }
}
