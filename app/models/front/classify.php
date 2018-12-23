<?php

namespace App\models\front;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\libraries\classes\search;

class classify extends Model
{
    protected $table = 'goods_classify';
    public $timestamps = false;
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
    public static function pageData(&$request)
    {
        $m = new search;
        $db = DB::table('goods_classify');
        $m->setSearch($db, $request);
        $data['page'] = $m->setPage($db, $request);
        $data['data'] = $db->where('parent', 0)->select('id', 'title', 'icon', 'level', 'sort')->orderBy('sort', 'asc')->get();
        return $data;
    }
    public function allData()
    {
        $res = $this->select('id', 'title', 'level', 'parent')->orderBy('sort', 'asc')->get();
        $data = [];
        foreach ($res as $k => $v) {
            $data[$v->parent][$v->id] = $v;
        }
        $tree = [];
        $this->tree($data, 0, $tree);
        return $tree;
    }
    private function tree(&$data, $pid, &$tree)
    {
        if (isset($data[$pid])) {
            foreach ($data[$pid] as $k => $v) {
                $tree[$k] = $v;
                $this->tree($data, $k, $tree);
            }
        }
    }
}
