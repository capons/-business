<?php

namespace App;

namespace App\model\DB;
use Illuminate\Database\Eloquent\Model;


class Script extends Model {
    protected $table = 'scripts';




    // guard attributes from mass-assignment
    protected $fillable = array('parent_id','users_id','name','desc');
}