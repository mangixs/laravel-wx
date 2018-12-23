<?php

namespace App\models\front;

use Illuminate\Database\Eloquent\Model;
use App\models\search;

class nav extends search
{
    protected $table = 'nav';
    public $timestamps = false;
    public function pageData(&$request)
	{
        $this->setSearch($this, $request);
        $data['page'] = $this->setPage($this, $request);
        $data['data'] = $this->select('nav.id', 'nav.title', 'nav.icon', 'nav.sort', 'nav.update_at', 'nav_type.title as type','nav.url')
            ->leftJoin('nav_type', 'nav_type.id', '=', 'nav.type_id')
            ->orderBy('nav.update_at', 'desc')
            ->get();
        foreach ($data['data'] as $key => &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return $data;
	}
}
