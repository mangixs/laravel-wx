<?php
namespace App\models;

use App\models\search;

class user extends search
{
    protected $table = 'user';
    public $timestamps = false;
}
