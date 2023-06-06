<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintEvaluation extends Model
{
    protected $fillable = ['id', 'complaintid', 'is_ontime','document', 'is_senior'];
}
