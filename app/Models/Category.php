<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Category extends Model
{
    protected $fillable = ['name','is_active'];

   // public function users(){
   //     return $this->hasMany(User::class,'department','id');
   // }
}
