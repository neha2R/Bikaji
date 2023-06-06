<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionTriggers extends Model
{
    protected $fillable=['action_id','role','is_email','is_sms'];

    public function rolerelation(){
        return $this->hasOne(Levels::class,'id','role');
    }
}
