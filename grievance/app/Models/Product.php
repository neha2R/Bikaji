<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Product extends Model
{
    protected $fillable = ['name','productid','is_active'];

   // public function users(){
   //     return $this->hasMany(User::class,'department','id');
   // }
}

