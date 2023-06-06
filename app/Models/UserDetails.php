<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserDetails extends Model
{
    protected $fillable=['user_id','dep_id','employee_id','other'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id', 'id');
    }
}
