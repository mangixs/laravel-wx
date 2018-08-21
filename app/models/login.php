<?php
namespace App\models;

use DB;
use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    protected $table = 'staff';
    public $timestamps = true;
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
    public function checkLogin($username, $pwd)
    {
        $res = $this->where('login_name', $username)->where('pwd', md5($pwd))->first();
        return $res;
    }
    public function getStaffJob($id)
    {
        $res = DB::table('staff_job')->where('staff_id', $id)->get();
        return $res;
    }
}
