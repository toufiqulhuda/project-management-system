<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $primaryKey = 'project_id';
    protected $fillable = [
        'title','description','duration',
        'start_at',
        'end_at',
        'status',
        'cost',
        'assigned_to',
        'assigned_at',
        'assigned_by',
        'assigned_by_ip',
        'isactive',
        'created_at','created_by','created_by_ip','updated_at','updated_by','updated_by_ip'
    ];

}
