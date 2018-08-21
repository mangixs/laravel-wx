<?php
if ( ! function_exists('p')) {
    function p($arr){
		if ( is_bool($arr) ) {
		    var_dump($arr);
		    exit;		
		}else{
			echo '<pre>';
			print_r($arr);
			echo '</pre>';
			exit;
		}    	
    }
}
if ( ! function_exists('load_class')) {
    function load_class($name,$param=[],$dir='/app/libraries/classes'){
		include_once base_path().$dir.'/'.$name.'.php';
		$name=$dir.'/'.$name;
		$name = preg_replace('/\//', '\\', $name);
		$classObj=new $name($param);
		return $classObj;    	
    }
}
/**
 * 无限分类
 * 返回树形结构
 */
if ( !function_exists('getTree') ) {
	function getTree($data, $pId){
        $tree = '';
        foreach($data as $k => $v){
            if($v['parent_id'] == $pId){
                $v['list'] = getTree($data, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }
}
/**
* 取汉字的第一个字的首字母
* @param type $str
* @return string|null
*/
if ( !function_exists('strFirstChart') ) {
	function strFirstChart($str){
		if(empty($str)){
			return '';
		}
		$fchar=ord($str{0});
		if($fchar>=ord('A')&&$fchar<=ord('z')){
			return strtoupper($str{0});
		} 			
		$s1=iconv('UTF-8','gb2312',$str);
		$s2=iconv('gb2312','UTF-8',$s1);
		$s=$s2==$str?$s1:$str;
		$asc=ord($s{0})*256+ord($s{1})-65536;
		if($asc>=-20319&&$asc<=-20284) return 'A';
		if($asc>=-20283&&$asc<=-19776) return 'B';
		if($asc>=-19775&&$asc<=-19219) return 'C';
		if($asc>=-19218&&$asc<=-18711) return 'D';
		if($asc>=-18710&&$asc<=-18527) return 'E';
		if($asc>=-18526&&$asc<=-18240) return 'F';
		if($asc>=-18239&&$asc<=-17923) return 'G';
		if($asc>=-17922&&$asc<=-17418) return 'H';
		if($asc>=-17417&&$asc<=-16475) return 'J';
		if($asc>=-16474&&$asc<=-16213) return 'K';
		if($asc>=-16212&&$asc<=-15641) return 'L';
		if($asc>=-15640&&$asc<=-15166) return 'M';
		if($asc>=-15165&&$asc<=-14923) return 'N';
		if($asc>=-14922&&$asc<=-14915) return 'O';
		if($asc>=-14914&&$asc<=-14631) return 'P';
		if($asc>=-14630&&$asc<=-14150) return 'Q';
		if($asc>=-14149&&$asc<=-14091) return 'R';
		if($asc>=-14090&&$asc<=-13319) return 'S';
		if($asc>=-13318&&$asc<=-12839) return 'T';
		if($asc>=-12838&&$asc<=-12557) return 'W';
		if($asc>=-12556&&$asc<=-11848) return 'X';
		if($asc>=-11847&&$asc<=-11056) return 'Y';
		if($asc>=-11055&&$asc<=-10247) return 'Z';
		return null;
	}
}
if ( !function_exists('getClientIp') ) {
	function getClientIp() {
	    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	        $ip = getenv('HTTP_CLIENT_IP');
	    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	        $ip = getenv('HTTP_X_FORWARDED_FOR');
	    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	        $ip = getenv('REMOTE_ADDR');
	    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    	return $res;
	}
}
/**
 * 将字符串参数变为数组
 * @param $query
 * @return array 
 * 
 */
function convertUrlQuery($query){
	$queryParts = explode('&', $query);
	$params = array();
	foreach ($queryParts as $param) {
		$item = explode('=', $param);
		$params[$item[0]] = $item[1];
	}
	return $params;
}
/**
 * 将参数变为字符串
 * @param $array_query
 * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1'
 */
function getUrlQuery($array_query){
  	$tmp = array();
  	foreach($array_query as $k=>$param){
    	$tmp[] = $k.'='.$param;
  	}
  	$params = implode('&',$tmp);
  	return $params;
}
/**
 * 生成随机字符串
 *
 * @param integer $len
 * @return void
 */
function randStr($len = 10)
{
    $str = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');
    $last = count($str) - 1;
    $rand = '';
    for ($i = 0; $i < $len; $i++) {
        $rand .= $str[rand(0, $last)];
    }
    return $rand;
}
