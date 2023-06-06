<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table='states';
    protected $primary_key='id';
    protected $fillable=[
        'state_name',
        'is_active'
    ];
}
