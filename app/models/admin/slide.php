<?php
namespace App\models\admin;

use App\models\search;

class slide extends search{
	protected $table = 'slide';
	public $timestamps = false;
	public function fromDateTime($value){
		return strtotime(parent::fromDateTime($value));
	}
	public function pageData(&$request)
	{
        $this->setSearch($this, $request);
        $data['page'] = $this->setPage($this, $request);
        $data['data'] = $this->select('slide.id', 'slide.title', 'slide.img', 'slide.sort', 'slide.update_at', 'slide_type.named as type')
            ->leftJoin('slide_type', 'slide_type.id', '=', 'slide.type')
            ->orderBy('slide.update_at', 'desc')
            ->get();
        foreach ($data['data'] as $key => &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return $data;
	}
}