<?php

namespace App\Models;
use Mail;
use App\Mail\ContactMail;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable=['name', 'email', 'phone', 'complaint'];
    public static function boot() {
  
        parent::boot();
  
        static::created(function ($item) {
                
            $adminEmail = "neha.rajvanshi@neologicx.in";
            Mail::to($adminEmail)->send(new ContactMail($item));
        });
    }
}
