<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transition extends Model
{
    protected $fillable=['complaintid','fromlevel','tolevel','fromuser','touser','is_resolved','resolutionid','departmentid','is_transfered','responseawait','resolutionresponse','transfer_comment'];

    public function fromuserrelation(){
        return $this->hasOne(User::class,'id','fromuser');
    }

    public function touserrelation(){
        return $this->hasOne(User::class,'id','touser');
    }

    public function complaint(){
        return $this->hasOne(Complaint::class,'id','complaintid');
    }
    
    public function department(){
        return $this->hasOne(Department::class,'id','departmentid');
    }

    public function evaluation(){
        return $this->hasOne(ComplaintEvaluation::class,'complaintid','complaintid');
    }
    public function scopeCrossedtimelinecomplaint($query)
    {
        // dd($this->complaint);
        // dd($query);
        $getdays = complaintlimit();
        $days = optional($query->complaint)->created_at->diffInDays(now());
        if ($days > $getdays) {
            return $query;
        } 
       
    }
}

