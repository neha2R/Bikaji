<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['name'];
    
    public function actiontrigger(){
        return $this->hasMany(ActionTriggers::class,'action_id','id');
    }
}
