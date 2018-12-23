<?php
namespace App\libraries\classes;

class search
{
    protected $__page_string = 'page';
    protected $__page_every_string = 'every';
    public function setSearch(&$db, &$request)
    {
        if (!$request->has('search')) {
            return;
        }
        $str = $request->input('search');
        if (empty($str)) {
            return;
        }
        $json = json_decode($str, true);
        if (!is_array($json)) {
            return;
        }
        foreach ($json as $k => $v) {
            $set = explode(':', $k);
            if (empty($v) or $v == -1) {
                continue;
            }
            $arr = explode(',', $set[1]);
            switch ($set[0]) {
                case 'like':
                    if (count($arr) == 1) {
                        $db->where($arr[0], 'like', '%' . $v . '%');
                    } else {
                        foreach ($arr as $row) {
                            $db->orWhere($row, 'like', '%' . $v . '%');
                        }
                    }
                    break;
                case 'equal':
                case '=':
                    if (count($arr) == 1) {
                        $db->where($arr[0], $v);
                    } else {
                        foreach ($arr as $row) {
                            $db->where($row, $v);
                        }
                    }
                    break;
                default:
                    if (in_array($set[0], ['>', '>=', '<', '<='])) {
                        if (count($arr) == 1) {
                            $db->where($arr[0], $set[0], $v);
                        } else {
                            foreach ($arr as $row) {
                                $db->where($row, $set[0], $v);
                            }
                        }
                    }
                    break;
            }
        }
    }
    public function setPage(&$db, &$request, $set_limit = true, $def_eve = 10)
    {
        $page = $request->input('page') ? $request->input($this->__page_string) : 1;
        $every = $request->input('every') ? $request->input($this->__page_every_string) : $def_eve;
        if (!is_numeric($page) and !is_numeric($every)) {
            exit;
        }
        $ret['every'] = $every;
        $ret['count_all'] = $db->count();
        $ret['page_count'] = ceil($ret['count_all'] / $every);
        if ($page > $ret['page_count'] + 1) {
            $page = $ret['page_count'] + 1;
        }
        $ret['page'] = $page;
        $set_limit && $db->offset(($page - 1) * $every)->limit($every);
        return $ret;
    }
}
