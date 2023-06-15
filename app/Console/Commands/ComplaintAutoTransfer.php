<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActionTriggers;
use App\Models\Notification;
use App\Jobs\ComplaintTransferred;
use App\Events\ComplaintTransfer;
use App\Models\Transition;
use App\Models\Complaint;
use App\Models\Resolution;

use App\Models\Configuration;
use App\User;
use Illuminate\Support\Carbon;




class ComplaintAutoTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ComplaintAutoTransfer:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */


     public function handle()
     {
        $resolveid = Resolution::pluck('complaint_id')->all();
        $allcomplaintid = Complaint::pluck('id')->all();
        $istransition = Transition::pluck('complaintid')->all();
        $complaintsnottransfer = Complaint::whereNotIn('id',$resolveid)->whereNotIn('id',$istransition)->orderBy('id', 'DESC')->get();
            if($complaintsnottransfer)
            {
                foreach ($complaintsnottransfer as $key1 => $value1) {

                    $transferDay = Configuration::where(['from' => 1, 'to' => 1])->get()->first()->days;
                    $complaintDate = $value1->created_at->diffInDays(Carbon::now());

                    if ($complaintDate >= $transferDay) {

                            $usertosend = User::whereRaw("find_in_set(2,department)")->where('role', 2)->first()->id;

                           // $usertosend = User::where(['department' => $department_to_user, 'role' => 3])->first()->id;
                            $usertosendcheck = Transition::where(['touser' => $usertosend])->where('is_resolved', '0')->count();

                            if (isset($usertosendcheck)) {
                                
                                $usertosend2 = User::whereRaw("find_in_set(2,department)")->where('role', 2)->where('id', '!=', $usertosend)->first('id');

                                if (isset($usertosend2)) {

                                  ///  $usertosend = User::whereRaw("find_in_set(2,department)")->where('role', 2)->where('id', '!=', $usertosend2->id)->first()->id;
                                  $usertosend =  $usertosend2->id;
                                } else {
                                   // dd("call6");

                                    $usertosend = $usertosend;
                                }
                            }
                            if($value1->createdby)
                            {

                                $fromuser=$value1->createdby;
                            }
                            else
                            {
                                $fromuser=0;  
                            }
                           // dd($fromuser);
                            $create = Transition::create(['complaintid' => $value1->id, 'fromlevel' => '1', 'tolevel' => 2, 'fromuser' => $fromuser, 'touser' => $usertosend, 'departmentid' => '2','transfer_comment' => 'Auto transfer', 'is_auto_transfer' => 1]);
                            $getemails = ActionTriggers::where('action_id', 2)->where('is_email', 1)->pluck('role');
                            $getsms = ActionTriggers::where('action_id', 2)->where('is_sms', 1)->pluck('role');
                            $toemails = [];
                            $tosms = [];
                            $tousers = [];
                            if (count($getemails)) {
                                foreach ($getemails as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $fromuser)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;

                                        case 2:
                                            array_push($toemails, User::first()->email);
                                            break;

                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;

                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }

                            if (count($getsms)) {
                                foreach ($getsms as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $fromuser)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;

                                        case 2:
                                            array_push($tosms, User::first()->mobile);
                                            break;

                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;

                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                            if (count($getemails)) {
                                foreach ($getemails as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $fromuser)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;

                                        case 2:
                                            array_push($tousers, User::first()->id);
                                            break;

                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;

                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                        
                    }
                    if (count($tousers)) {
                        foreach ($tousers as $key => $value) {
                            Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $createdbyuser->title . ' </b> has been transferred.']);
                        }
                    }
                    ComplaintTransferred::dispatchNow($toemails, $tosms, $value1->title, $value1->touserrelation->name, $value1->customername, $usertosend->name, $value1->details);

                }


            }

           
                $Complaint = Transition::whereNotIn('complaintid',$resolveid)->whereIn('complaintid', $allcomplaintid)->with('touserrelation')->latest()->get()->unique('complaintid');
               //// dd($Complaint);
               if($complaintsnottransfer)
            {
                foreach ($Complaint as $key => $value) {
                    if ($value->touserrelation == !null) {
        
                        $role = $value->touserrelation->role;
                        $department_to_user = $value->touserrelation->department;
                        $createdbyuser = $value->complaint;
        
                        if ($role == 2 && isset($createdbyuser) && $department_to_user !== 5) {
                            $usertosendrole = User::where('id', $value->touser)->pluck('role')->first();

                            $transferDay = Configuration::where(['to' =>$usertosendrole])->get()->first()->days;

                            $complaintDate = $value->created_at->diffInDays(Carbon::now());

                            if ($complaintDate >= $transferDay) {

                         ////   $usertosend2 = User::whereRaw("find_in_set($value->departmentid,department)")->where('role', $usertosendrole+1)->first('id');
        
                            $update = Transition::find($value->id)->update(['is_transfered' => 1, 'transfer_comment' => 'Auto transfer', 'is_auto_transfer' => 1]);
                            if ($update) {
                                $usertosend2 = User::whereRaw("find_in_set($value->departmentid,department)")->where('role', $usertosendrole+1)->first()->id;

                             //   $usertosend = User::where(['department' => $value->departmentid, 'role' => $usertosendrole+1])->first()->id;
                                $usertosendcheck = Transition::where(['touser' => $usertosend2])->where('is_resolved', '0')->count();
                                if (isset($usertosendcheck)) {
                                    $usertosend2 = User::whereRaw("find_in_set($value->departmentid,department)")->where('role', $usertosendrole+1)->where('id', '!=', $usertosend2)->first('id');
                                  //  dd("call2");

                                  //dd($usertosend2);
                                }
                                 else {
                                        $usertosend2 = $usertosend2;
                                      //  dd("call6");
                                    }
                                
                               $create = Transition::create(['complaintid' => $value->complaintid, 'fromlevel' => $usertosendrole, 'tolevel' => $usertosendrole+1, 'fromuser' => $value->touser, 'touser' => $usertosend2->id, 'departmentid' => $value->departmentid,'transfer_comment' => 'Auto transfer', 'is_auto_transfer' => 1]);
                            //   dd($create);
                               
                              
                                 ////   $create = Transition::create(['complaintid' => $value->complaintid, 'fromlevel' => $role, 'tolevel' => 0, 'fromuser' => $value->touserrelation->id, 'touser' => $usertosend, 'departmentid' => $department_to_user]);
                                    $getemails = ActionTriggers::where('action_id', $usertosendrole+1)->where('is_email', 1)->pluck('role');
                                    $getsms = ActionTriggers::where('action_id', $usertosendrole+1)->where('is_sms', 1)->pluck('role');
                                    $toemails = [];
                                    $tosms = [];
                                    $tousers = [];
                                    if (count($getemails)) {
                                        foreach ($getemails as $value) {
                                            switch ($value) {
                                                case 1:
                                                    $getuser = User::where('id', $value->fromuser)->first();
                                                    if ($getuser) {
                                                        array_push($toemails, $getuser->email);
                                                    }
                                                    break;
        
                                                case 2:
                                                    array_push($toemails, User::first()->email);
                                                    break;
        
                                                case 3:
                                                    $getuser = User::where('id', $usertosend2)->first();
                                                    if ($getuser) {
                                                        array_push($toemails, $getuser->email);
                                                    }
                                                    break;
        
                                                case 4:
                                                    $getuser = User::where('role', $value)->first();
                                                    if ($getuser) {
                                                        array_push($toemails, $getuser->email);
                                                    }
                                                    break;
        
                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                    }
        
                                    if (count($getsms)) {
                                        foreach ($getsms as $value) {
                                            switch ($value) {
                                                case 1:
                                                    $getuser = User::where('id', $value->fromuser)->first();
                                                    if ($getuser) {
                                                        array_push($tosms, $getuser->mobile);
                                                    }
                                                    break;
        
                                                case 2:
                                                    array_push($tosms, User::first()->mobile);
                                                    break;
        
                                                case 3:
                                                    $getuser = User::where('id', $usertosend2)->first();
                                                    if ($getuser) {
                                                        array_push($tosms, $getuser->mobile);
                                                    }
                                                    break;
        
                                                case 4:
                                                    $getuser = User::where('role', $value)->first();
                                                    if ($getuser) {
                                                        array_push($tosms, $getuser->mobile);
                                                    }
                                                    break;
        
                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                    }
                                    if (count($getemails)) {
                                        foreach ($getemails as $value) {
                                            switch ($value) {
                                                case 1:
                                                    $getuser = User::where('id', $value->fromuser)->first();
                                                    if ($getuser) {
                                                        array_push($tousers, $getuser->id);
                                                    }
                                                    break;
        
                                                case 2:
                                                    array_push($tousers, User::first()->id);
                                                    break;
        
                                                case 3:
                                                    $getuser = User::where('id', $usertosend2)->first();
                                                    if ($getuser) {
                                                        array_push($tousers, $getuser->id);
                                                    }
                                                    break;
        
                                                case 4:
                                                    $getuser = User::where('role', $value)->first();
                                                    if ($getuser) {
                                                        array_push($tousers, $getuser->id);
                                                    }
                                                    break;
        
                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                    }
                                }
                            }
                            if (count($tousers)) {
                                foreach ($tousers as $key => $value) {
                                    Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $createdbyuser->title . ' </b> has been transferred.']);
                                }
                            }
                            ComplaintTransferred::dispatchNow($toemails, $tosms, $createdbyuser->title, $value->touserrelation->name, $createdbyuser->customername, $usertosend2->name, $createdbyuser->details);

                            // ComplaintTransferred::dispatchNow($toemails, $tosms, $createdbyuser->title, User::first()->name, $createdbyuser->customername, User::find($usertosend)->name, 'Auto Transferd');
                            // event(new ComplaintTransfer($usertosend, $createdbyuser->title));
        
                        }
                    }
                }
            }
                echo "done";

            
     
    
}


        ////$Complaint = Transition::where('is_resolved', 0)->with('touserrelation')->get();

        public function handle22()
        {
            $getdays = complaintlimit();
        
            $complaints = Complaint::whereNotIn('id',$resolveid)->whereDate('created_at','<', Carbon::now()->subDays($getdays)->format('Y-m-d'));
            if($complaintsnottransfer)
            {
                foreach ($complaintsnottransfer as $key1 => $value1) {
        
                    $transferDay = Configuration::where(['from' => 1, 'to' => 1])->get()->first()->days;
                    $complaintDate = $value1->created_at->diffInDays(Carbon::now());
        
                    if ($complaintDate >= $transferDay) {
        
                            $usertosend = User::whereRaw("find_in_set(2,department)")->where('role', 2)->first()->id;
        
                           // $usertosend = User::where(['department' => $department_to_user, 'role' => 3])->first()->id;
                            $usertosendcheck = Transition::where(['touser' => $usertosend])->where('is_resolved', '0')->count();
        
                            if (isset($usertosendcheck)) {
                                
                                $usertosend2 = User::whereRaw("find_in_set(2,department)")->where('role', 2)->where('id', '!=', $usertosend)->first('id');
        
                                if (isset($usertosend2)) {
        
                                  ///  $usertosend = User::whereRaw("find_in_set(2,department)")->where('role', 2)->where('id', '!=', $usertosend2->id)->first()->id;
                                  $usertosend =  $usertosend2->id;
                                } else {
                                   // dd("call6");
        
                                    $usertosend = $usertosend;
                                }
                            }
                            if($value1->createdby)
                            {
        
                                $fromuser=$value1->createdby;
                            }
                            else
                            {
                                $fromuser=0;  
                            }
                           // dd($fromuser);
                            $create = Transition::create(['complaintid' => $value1->id, 'fromlevel' => '1', 'tolevel' => 2, 'fromuser' => $fromuser, 'touser' => $usertosend, 'departmentid' => '2','transfer_comment' => 'Auto transfer', 'is_auto_transfer' => 1]);
                            $getemails = ActionTriggers::where('action_id', 2)->where('is_email', 1)->pluck('role');
                            $getsms = ActionTriggers::where('action_id', 2)->where('is_sms', 1)->pluck('role');
                            $toemails = [];
                            $tosms = [];
                            $tousers = [];
                            if (count($getemails)) {
                                foreach ($getemails as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $fromuser)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;
        
                                        case 2:
                                            array_push($toemails, User::first()->email);
                                            break;
        
                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;
        
                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;
        
                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
        
                            if (count($getsms)) {
                                foreach ($getsms as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $fromuser)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;
        
                                        case 2:
                                            array_push($tosms, User::first()->mobile);
                                            break;
        
                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;
        
                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;
        
                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                            if (count($getemails)) {
                                foreach ($getemails as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $fromuser)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;
        
                                        case 2:
                                            array_push($tousers, User::first()->id);
                                            break;
        
                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;
        
                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;
        
                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                        
                    }
                    if (count($tousers)) {
                        foreach ($tousers as $key => $value) {
                            Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $createdbyuser->title . ' </b> has been transferred.']);
                        }
                    }
                    ComplaintTransferred::dispatchNow($toemails, $tosms, $value1->title, $value1->touserrelation->name, $value1->customername, $usertosend->name, $value1->details);
        
                }
        
        
            }
        
        }
  
    public function handle1()
    {
        $Complaint = Transition::where('is_resolved', 0)->with('touserrelation')->get();
        foreach ($Complaint as $key => $value) {
            if ($value->touserrelation == !null) {

                $role = $value->touserrelation->role;
                $department_to_user = $value->touserrelation->department;
                $createdbyuser = $value->complaint;

                if ($role == 2 && isset($createdbyuser) && $department_to_user !== 5) {
                    $transferDay = Configuration::where(['from' => 1, 'to' => 1])->get()->first()->days;
                    $complaintDate = $value->created_at->diffInDays(Carbon::now());
                    if ($complaintDate >= $transferDay) {
                        $update = Transition::find($value->id)->update(['is_transfered' => 1, 'transfer_comment' => 'Auto transfer', 'is_auto_transfer' => 1]);
                        if ($update) {
                            $usertosend = User::where(['department' => $department_to_user, 'role' => 3])->first()->id;
                            $usertosendcheck = Transition::where(['touser' => $usertosend])->where('is_resolved', '0')->count();
                            if (isset($usertosendcheck)) {
                                $usertosend2 = User::where(['department' => $department_to_user, 'role' => 3])->where('id', '!=', $usertosend)->first('id');
                                if (isset($usertosend2)) {
                                    $usertosend = User::where(['department' => $department_to_user, 'role' => 3])->where('id', '!=', $usertosend)->first()->id;
                                } else {
                                    $usertosend = $usertosend;
                                }
                            }
                            $create = Transition::create(['complaintid' => $value->complaintid, 'fromlevel' => $role, 'tolevel' => 0, 'fromuser' => $value->touserrelation->id, 'touser' => $usertosend, 'departmentid' => $department_to_user]);
                            $getemails = ActionTriggers::where('action_id', 2)->where('is_email', 1)->pluck('role');
                            $getsms = ActionTriggers::where('action_id', 2)->where('is_sms', 1)->pluck('role');
                            $toemails = [];
                            $tosms = [];
                            $tousers = [];
                            if (count($getemails)) {
                                foreach ($getemails as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $createdbyuser->createdby)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;

                                        case 2:
                                            array_push($toemails, User::first()->email);
                                            break;

                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;

                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($toemails, $getuser->email);
                                            }
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }

                            if (count($getsms)) {
                                foreach ($getsms as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $createdbyuser->createdby)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;

                                        case 2:
                                            array_push($tosms, User::first()->mobile);
                                            break;

                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;

                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($tosms, $getuser->mobile);
                                            }
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                            if (count($getemails)) {
                                foreach ($getemails as $value) {
                                    switch ($value) {
                                        case 1:
                                            $getuser = User::where('id', $createdbyuser->createdby)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;

                                        case 2:
                                            array_push($tousers, User::first()->id);
                                            break;

                                        case 3:
                                            $getuser = User::where('id', $usertosend)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;

                                        case 4:
                                            $getuser = User::where('role', $value)->first();
                                            if ($getuser) {
                                                array_push($tousers, $getuser->id);
                                            }
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                        }
                    }
                    if (count($tousers)) {
                        foreach ($tousers as $key => $value) {
                            Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $createdbyuser->title . ' </b> has been transferred.']);
                        }
                    }
                    // ComplaintTransferred::dispatchNow($toemails, $tosms, $createdbyuser->title, User::first()->name, $createdbyuser->customername, User::find($usertosend)->name, 'Auto Transferd');
                    // event(new ComplaintTransfer($usertosend, $createdbyuser->title));

                }
            }
        }
        echo "done";
    }
}
