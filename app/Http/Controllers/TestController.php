<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Transition;
use App\Traits\SmsTrait;
use Illuminate\Support\Facades\Http;
use App\City;
use App\State;

class TestController extends Controller
{
    use SmsTrait;
   
    public function createcomplaint(){
       $compid= Complaint::create(['uuid'=>'hello','customername'=>'kkk'])->id;
       $txn=Transition::create(['complaintid'=>$compid,'fromlevel'=>1,'tolevel'=>2,'fromuser'=>1,'touser'=>2,'departmentid'=>1]);
        
    }

    public function transfer($text,$compid,$userid){
        return response()->json(['status'=>200,'text'=>$text,'compid'=>$compid,'userid'=>$userid]);
    }

    public function testsms(){
       
        $mobile=8619276817;
        $res = Http::get('http://alerts.prioritysms.com/api/web2sms.php', [
            'workingkey' => 'Ad18f0224ee63efc00b7d3817d46f7fdc',
            'to' => $mobile,
            'sender'=>'BIKAJI',
            'message'=>'Hello testing',
        ]);
//dd($res);
    }
    public function state(){
        $state= State::get();
        return response()->json(json_decode($state));
    }
    public function city(Request $request){
        $state=State::where('state_name',$request->state)->first()->id;
        $city=City::where('state_id',$state)->get();
        return response()->json(json_decode($city));
    }
}
