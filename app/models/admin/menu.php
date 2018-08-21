<?php
namespace App\models\admin;

use App\models\search;

class menu extends search
{
    protected $table = 'menu';
    public $timestamps = false;
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
    public function pageData(&$request)
    {
        $this->where('parent', 0);
        $this->setSearch($this, $request);
        $data['page'] = $this->setPage($this, $request);
        $data['data'] = $this->where('parent', 0)->select('id', 'named', 'url', 'sort', 'level', 'parent')->orderBy('sort', 'asc')->get();
        return $data;
	}
	public function getChildData($pid)
	{
		$ret = $this->where('parent', $pid)->select('id', 'named', 'url', 'sort', 'level', 'parent')->orderBy('sort', 'asc')->get();
		return $ret;
	}
}
