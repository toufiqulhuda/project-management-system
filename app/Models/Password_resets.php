<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Password_resets extends Model
{

    protected $fillable = [
        'email',
        'token',
        'created_at',
        'created_by',
        'created_by_ip',
    ];



}
