<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\models\user;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private function getOpenId($code)
    {
        if (empty($code)) {
            return response()->json(['result' => 'ERROR', 'msg' => 'code错误']);
        }
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . getenv('wxAppid') . '&secret=' . getenv('wxSecret') . '&js_code=' . $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
    public function login(Request $request)
    {
        $params = $request->all();
        $res = $this->getOpenId($params['code']);
        if (!$res || empty($res['openid'])) {
            return response()->json(['result' => 'ERROR', 'msg' => '获取openid错误', 'data' => $res]);
        } else {
            $decryptRes = $this->decryptData($res['session_key'], $params['encryptedData'], $params['iv'], $data);
            if ($decryptRes === 'ok') {
                $data = json_decode($data, true);
                $userinfo = user::where('openid', $data['openId'])->first();
                $user['nickname'] = $data['nickName'];
                $user['avatarurl'] = $data['avatarUrl'];
                $user['openid'] = $data['openId'];
                $user['province'] = $data['province'];
                $user['city'] = $data['city'];
                $user['gender'] = $data['gender'];
                $user['country'] = $data['country'];
                if (empty($userinfo)) {
                    $user['insert_at'] = time();
                    $id = user::insertGetId($user);
                    $userinfo = user::find($id);
                }else{
                    user::where('openid',$data['openId'])->update($user);
                }
                return response()->json(['result' => 'SUCCESS', 'msg' => '登陆成功', 'data' => $userinfo]);
            } else {
                return response()->json(['result' => 'ERROR', 'msg' => '登录失败', 'msg' => $decryptRes]);
            }
        }
    }
    private function decryptData($sessionKey, $encryptedData, $iv, &$data)
    {
        $appid = getenv('wxAppid');
        if (strlen($sessionKey) != 24) {
            return 'encodingAesKey 非法';
        }
        $aesKey = base64_decode($sessionKey);
        if (strlen($iv) != 24) {
            return 'iv数据非法1';
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = $this->decrypt($aesKey, $aesCipher, $aesIV);
        if ($result[0] != 0) {
            return $result[0];
        }
        $dataObj = json_decode($result[1]);
        if ($dataObj == null) {
            return 'aes 解密失败2';
        }
        if ($dataObj->watermark->appid != $appid) {
            return 'aes 解密失败3';
        }
        $data = $result[1];
        return 'ok';
    }
    private function decrypt($aesKey, $aesCipher, $aesIV)
    {
        try {
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            mcrypt_generic_init($module, $aesKey, $aesIV);
            $decrypted = mdecrypt_generic($module, $aesCipher);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            return 'aes 解密失败4';
        }
        try {
            $result = $this->decode($decrypted);
        } catch (Exception $e) {
            return 'aes 解密失败5';
        }
        return array(0, $result);
    }
    private function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }
}
