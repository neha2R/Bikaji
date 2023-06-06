<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table='cities';
    protected $primary_key='id';
    protected $fillable=[
        'city_name',
        'state_id',
        'is_active'
    ];
}
