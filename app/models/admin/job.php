<?php
namespace App\models\admin;

use App\models\search;

class job extends search{
	protected $table = 'admin_job';
	public $timestamps = false;
	public function fromDateTime($value){
		return strtotime(parent::fromDateTime($value));
	}
	public function pageData(&$request)
	{
		$this->setSearch($this,$request);
		$data['page'] = $this->setPage($this,$request);
		$data['data'] = $this->select('id', 'job_name')->orderBy('id', 'desc')->get();
		return $data;
	}
}