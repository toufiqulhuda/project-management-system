<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    protected $primaryKey = 'id';
    protected $fillable = [
        'file_name','file_path','project_id',
        'created_at','created_by','created_by_ip','updated_at','updated_by','updated_by_ip'
    ];

}
