<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Inquiry extends Model
{
    protected $guarded=[];

    public function departmentrelation()
    {
        return $this->hasOne(Department::class,'id','inquirytype');
    }

    public function inquirysourcerelation()
    {
        return $this->hasOne(InquiryType::class,'id','inquirysource');
    }

    public function inquiryresolutionrelation(){
        return $this->hasOne(InquiryResolution::class,'inquiry_id','id');
    }

    public function touserrelation(){
        return $this->hasOne(User::class,'id','createdby');
    }
}
