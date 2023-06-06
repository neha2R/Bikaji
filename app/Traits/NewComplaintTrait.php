<?php
namespace App\Traits;
use App\Models\ActionTriggers;
use App\User;
trait NewComplaintTrait{

    public function email($depid){
        $roles=ActionTriggers::where(['action_id'=>1,'is_email'=>1])->get();
        $emails=array();
        
        foreach ($roles as $key => $value) {
            switch ($value->role) {
                case 1:
                    array_push($emails,auth()->user()->email);
                    break;
                case 2:
                    $email=User::where(['department'=>$depid,'role'=>$value->role])->first();
                    if ($email) {
                        array_push($emails,$email->email);
                    }
                    break;
                case 3:
                    $email=User::where(['department'=>$depid,'role'=>$value->role])->first();
                    if ($email) {
                        array_push($emails,$email->email);
                    }
                    break;
                case 4:
                   $email=User::where('role',$value->role)->first();
                   if ($email) {
                    array_push($emails,$email->email);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        return $emails;
    }

    public function sms($depid){
        $roles=ActionTriggers::where(['action_id'=>1,'is_sms'=>1])->get();
        $mobiles=array();
        
        foreach ($roles as $key => $value) {
            switch ($value->role) {
                case 1:
                    array_push($mobiles,auth()->user()->mobile);
                    break;
                case 2:
                    $email=User::where(['department'=>$depid,'role'=>$value->role])->first();
                    if ($email) {
                        array_push($mobiles,$email->mobile);
                    }
                    break;
                case 3:
                    $email=User::where(['department'=>$depid,'role'=>$value->role])->first();
                    if ($email) {
                        array_push($mobiles,$email->mobile);
                    }
                    break;
                case 4:
                   $email=User::where('role',$value->role)->first();
                   if ($email) {
                    array_push($mobiles,$email->mobile);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        return $mobiles;
    }

    public function users($depid){
        $roles=ActionTriggers::where(['action_id'=>1,'is_email'=>1])->get();
        $users=array();
        
        foreach ($roles as $key => $value) {
            switch ($value->role) {
                case 1:
                    array_push($users,auth()->user()->id);
                    break;
                case 2:
                    $user=User::where(['department'=>$depid,'role'=>$value->role])->first();
                    if ($user) {
                        array_push($users,$user->id);
                    }
                    break;
                case 3:
                    $user=User::where(['department'=>$depid,'role'=>$value->role])->first();
                    if ($user) {
                        array_push($users,$user->id);
                    }
                    break;
                case 4:
                   $user=User::where('role',$value->role)->first();
                   if ($user) {
                    array_push($users,$user->id);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        return $users;
    }
}