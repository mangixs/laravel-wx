<?php
namespace App\models\admin;

use App\models\search;

class shop extends search
{
    protected $table = 'shop';
    public $timestamps = true;
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
    public function pageData(&$request)
    {
        $this->where('valid', 1);
        $this->setSearch($this, $request);
        $data['page'] = $this->setPage($this, $request);
        $data['data'] = $this->select('id', 'title', 'login_name', 'contact', 'tel')->orderBy('updated_at', 'desc')->get();
        return $data;
    }
    public function allShop()
    {
        $ret = $this->where('valid', 1)->select('id', 'title')->orderBy('updated_at', 'desc')->get();
        return $ret;
    }
}
