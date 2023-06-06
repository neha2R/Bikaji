<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryResolution extends Model
{
    protected $fillable = ['id', 'inquiry_id', 'resolution', 'customerresponse'];
}
