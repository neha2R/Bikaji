<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Department extends Model
{
    protected $fillable = ['name','is_active'];

    public function users(){
        return $this->hasMany(User::class,'department','id');
    }
}
