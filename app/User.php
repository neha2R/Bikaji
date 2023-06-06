<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserDetails;
use App\Models\Department;
use App\Models\Levels;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','remember_token','profileimage','mobile','role','department'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function details(){
        return $this->hasOne(UserDetails::class,'user_id','id');
    }

    public function roleuser()
    {
        return $this->belongsTo(Levels::class, 'role', 'id');
    }

    public function getdepname(){
        return $this->belongsTo(Department::class, 'department', 'id');
    }
    
}
