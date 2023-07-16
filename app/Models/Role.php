<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $primaryKey = 'roleid';
    protected $fillable = [
        'role_name','description','isactive','created_by','created_by_ip','created_at','updated_at','updated_by','updated_by_ip',
    ];

}
