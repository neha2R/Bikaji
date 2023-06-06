<?php

use App\Models\Complaint;
use App\Models\ComplaintEvaluation;
use App\Models\Configuration;
use App\Models\Inquiry;
use App\Models\InquiryEvaluation;
use App\Models\InquiryResolution;
use App\Models\InquiryTransactions;
use App\Models\Levels;
use App\Models\Notification;
use App\Models\Resolution;
use App\Models\UserDetails;
use App\User;

function levelname($id){
    try {
       return Levels::findorfail($id)->name;
    } catch (\Throwable $th) {
        $this->customerr($th);
    }
}

function compaintnamehelper(){
    return 'BIKCOMP'.time();
}

function enquirynamehleper(){
    return 'BIKENQ'.time();
}

function datefomat($date){
    return date("F j, Y, g:i a", strtotime($date));
}

function getresolution($id){
    try {
        $resolution = Resolution::where('complaint_id', $id)->first();
        // if ($resolution) {
        //     $resolution = $resolution->resolution;
        // } else {
        //     $resolution = '';
        // }
        return $resolution;
    } catch (\Throwable $th) {
        //throw $th;
    }
}

function inquirygetresolution($id){
    try {
        $resolution = InquiryResolution::where('inquiry_id', $id)->first();
        return $resolution;
    } catch (\Throwable $th) {
        //throw $th;
    }
}

function getinquiryresolution($id){
    try {
        $resolution = InquiryResolution::where('inquiry_id', $id)->first();
        if ($resolution) {
            $resolution = $resolution->resolution;
        } else {
            $resolution = '';
        }
        return $resolution;
    } catch (\Throwable $th) {
        //throw $th;
    }
}

function getcomplaintregisterdate($id){
    $date = Complaint::where('id', $id)->first()->created_at;
    return $date;
}

function getinquiryregisterdate($id){
    $date = Inquiry::where('id', $id)->first()->created_at;
    return $date;
}

function checkifresolved($id){
    try {
        $check = Resolution::where('complaint_id', $id)->exists();
        return $check;
    } catch (\Throwable $th) {
        $this->customerr($th);
    }
}

function inquirycheckifresolved($id){
    $check = InquiryResolution::where('inquiry_id', $id)->exists();
        return $check;
}

function checkifinquiryclosed($id){
    $check = InquiryTransactions::where('inquiryid', $id)->where('is_resolved', 1)->exists();
    return $check;
}

function getlimitdays($id){
    $getdepid = User::where('id', $id)->first()->role;
    $days = Configuration::where('to', $getdepid)->first()->days;
    return $days;
}

function complaintlimit(){
    $days = Configuration::sum('days');
    return $days;
}

function getevaluation($id){
    $evaluation = ComplaintEvaluation::where('complaintid', $id)->first();
    if ($evaluation) {
        $evaluation = $evaluation->is_ontime;
    } else {
        $evaluation = 0;
    }
    
    return $evaluation;
}

function checkifsenior($id){
    $evaluation = ComplaintEvaluation::where('complaintid', $id)->first();
    if ($evaluation) {
        $evaluation = $evaluation->is_senior;
    } else {
        $evaluation = 0;
    }
    
    return $evaluation;
}

function inquirycheckifsenior($id){
    $evaluation = InquiryEvaluation::where('inquiryid', $id)->first();
    if ($evaluation) {
        $evaluation = $evaluation->is_senior;
    } else {
        $evaluation = 0;
    }
    
    return $evaluation;
}

function inquirygetevaluation($id){
    $evaluation = InquiryEvaluation::where('inquiryid', $id)->first();
    if ($evaluation) {
        $evaluation = $evaluation->is_ontime;
    } else {
        $evaluation = 0;
    }
    
    return $evaluation;
}

function inquirycheckiftransferred($id){
    $check = InquiryTransactions::where('inquiryid', $id)->where('is_transfered', 1)->exists();
    return $check;    
}

function countofnotification($id){
    $count = Notification::where('userid', $id)->where('is_read', 0)->count();
    return $count;
}

function getnotifications($id){
    $notifications = Notification::where('userid', $id)->where('is_read', 0)->orderBy('id', 'DESC')->get();
    return $notifications;
}

function getcaller(){
    $user = User::where('role', 1)->first();
    if ($user) {
        return $user;
    } else {
        $data['department'] = '';
        $data['name'] = '';
        return $data;
    }
    
}
