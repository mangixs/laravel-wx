<?php
namespace App\models\admin;

use App\models\search;
use DB;

class staff extends search
{
    protected $table = 'staff';
    public $timestamps = false;
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
    public static function allData()
    {
        $tmp = DB::table('staff')->select('id', 'true_name')->orderBy('id', 'asc')->get();
        return $tmp;
    }
    public function pageData(&$request)
    {
        $this->setSearch($this, $request);
        $data['page'] = $this->setPage($this, $request);
        $data['data'] = $this->select('id', 'login_name', 'staff_num', 'sex', 'true_name')->orderBy('id', 'asc')->get();
        return $data;
    }
}
