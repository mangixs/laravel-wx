<?php
namespace App\models\admin;

use App\models\search;

class func extends search
{
    protected $table = 'background_func';
    protected $primaryKey = 'key';
    public $timestamps = false;
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
    public function pageData(&$request)
    {
        $this->setSearch($this, $request);
        $data['page'] = $this->setPage($this, $request);
        $data['data'] = $this->select('key as keys', 'func_name')->orderBy('key', 'asc')->get();
        return $data;
    }
    public function single($id)
    {
        $data = $this->select('key as keys', 'func_name')->where('key', $id)->first();
        return $data;
    }
}
