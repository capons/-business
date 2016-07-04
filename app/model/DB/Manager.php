<?php

namespace App;

namespace App\model\DB;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model {
    protected $fillable = array('users_id','name','login','password','active','access','hash');
    public $table = 'manager';
    public $timestamps = true;

    function users(){
        $this->belongsTo('App\User');
    }
}