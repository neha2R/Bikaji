<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryEvaluation extends Model
{
    protected $fillable = ['id', 'inquiryid', 'document','is_ontime', 'is_senior'];
}
