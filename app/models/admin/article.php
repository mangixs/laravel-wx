<?php
namespace App\models\admin;

use App\models\search;

class article extends search{
	protected $table = 'article';
	public $timestamps = false;
	public function fromDateTime($value){
		return strtotime(parent::fromDateTime($value));
	}
	public function pageData(&$request)
	{
		$this->setSearch($this,$request);
		$ret['page'] = $this->setPage($this,$request);
		$ret['data'] = $this->select('article.id', 'article.title', 'article_type.named as type', 'article.update_at', 'article.first_img', 'article.sort')
            ->leftJoin('article_type', 'article_type.id', '=', 'article.type')
            ->orderBy('article.update_at', 'desc')
            ->where('article.valid', 1)
            ->get();
        foreach ($ret['data'] as &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return $ret;
	}
}