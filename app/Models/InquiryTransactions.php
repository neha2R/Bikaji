<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class InquiryTransactions extends Model
{
    protected $fillable=['inquiryid','fromlevel','tolevel','fromuser','touser','is_resolved','resolutionid','departmentid','is_transfered', 'transfer_comment', 'resolutionresponse', 'responseawait', 'resolvedate'];

    public function fromuserrelation(){
        return $this->hasOne(User::class,'id','fromuser');
    }

    public function touserrelation(){
        return $this->hasOne(User::class,'id','touser');
    }

    public function inquiry(){
        return $this->hasOne(Inquiry::class,'id','inquiryid');
    }

    public function department(){
        return $this->hasOne(Department::class,'id','departmentid');
    }
}
