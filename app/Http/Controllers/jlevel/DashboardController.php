<?php

namespace App\Http\Controllers\jlevel;

use App\Events\ComplaintResolved as AppComplaintResolved;
use App\Events\ComplaintTransfer;
use App\Events\InquiryResolvedEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ComplaintResolved;
use App\Jobs\ComplaintTransferred;
use App\Jobs\InquiryResolved;
use App\Jobs\InquiryTransferred;
use App\Models\ActionTriggers;
use App\Models\Complaint;
use App\Models\ComplaintEvaluation;
use App\Models\Department;
use App\Models\Inquiry;
use App\Models\InquiryEvaluation;
use App\Models\InquiryResolution;
use App\Models\InquiryTransactions;
use App\Models\Notification;
use App\Models\Resolution;
use App\Models\Transition;
use App\User;
use Illuminate\Http\Request;
use App\Models\InquiryType;
use Carbon\Carbon;
use App\Exports\OtherInquiryExport;

use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        try {
       $data=Transition::where(['touser'=>auth()->user()->id])->get();
            
          $departments = Department::with('users')->get();
                        $complaintid = Complaint::pluck('id')->all();
            $resolveid = Resolution::where('user_id',auth()->user()->id)->pluck('complaint_id')->all();
            $resolveuserid = Resolution::pluck('user_id')->all();
             if (request()->has('type')) {
                 $data = Transition::where(['is_transfered' => 0, 'is_resolved' => 1])->whereIn('complaintid',$resolveid)->orderBy('id', 'DESC')->get()->unique('complaintid');
           } else {
                $data = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->orderBy('id', 'DESC')->get()->unique('complaintid');
          }
            $countactive = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->get()->unique('complaintid')->count();
            $countresolved = Transition::where(['is_transfered' => 0, 'is_resolved' => 1])->whereIn('complaintid',$complaintid)->whereIn('complaintid',$resolveid)->get()->unique('complaintid')->count();

            //$data = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->orderBy('id', 'DESC')->get();
           // $departments = Department::with('users')->get();

            return view('juniorlevel.dashboard', compact('data', 'departments', 'countactive', 'countresolved'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function complaint()
    {
        try {
                    $complaintid = Complaint::pluck('id')->all();
            $data = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->orderBy('id', 'DESC')->get()->unique('complaintid');
            $departments = Department::with('users')->get();
            return view('juniorlevel.complaint', compact('data', 'departments'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function inquiry(Request $req)
    {
        try {
            $inquirysource = InquiryType::all();
            $users = User::all();

            $data = InquiryTransactions::where(['touser' => auth()->user()->id, 'is_transfered' => 0])->orderBy('id', 'DESC')->pluck('inquiryid')->all();
            $resolveinquiry = InquiryResolution::whereIn('id',$data)->pluck('inquiry_id')->all();

            $departments = Department::with('users')->get();
            if (request()->has('startdate') && request()->has('enddate')) {
                $from = strtotime(request()->startdate);
                $from = date("Y-m-d", $from);
                $to = strtotime(request()->enddate);
                $to = date("Y-m-d", $to);
                $data = Inquiry::whereIn('id',$data)->whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [$from . " 00:00:00", $to . " 23:59:59"]
                )->orderBy('id', 'desc')->get();
                        } 
            elseif ($req->type) {
           
                if ($req->type == 'resolved') {
                    $data =   Inquiry::whereIn('id',$resolveinquiry)->get();

                    //////// $resolvedinquiries = InquiryTransactions::where('is_resolved', 1)->whereRaw("(updated_at >= ? AND updated_at <= ?)", [$from . " 00:00:00", $to . " 23:59:59"])->get()->unique('inquiryid');
                     // dd($resolvedinquiries);
                    
                
                      }
                if ($req->type == 'pending') {
                    $data =   Inquiry::whereIn('id',$data)->whereNotIn('id',$resolveinquiry)->get();

                   
                    if(isset($req->export))
                    {
                       ////dd('call');
                $data=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereNotIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
                return Excel::download(new OtherInquiryExport($data), 'Inquiries.xlsx');
           
                    }
                }
               
            } 
            else if ($req->inqsource) {
                $data =   Inquiry::where('inquirysource',$req->inqsource)->whereIn('id',$data)->get();
                 //// $data = Inquiry::where('inquirysource',$req->inqsource)->orderBy('id', 'desc')->get();

            }
            
             if(isset($req->export))
             {
                 if ($req->type == 'resolved') {
                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
                  //   dd($data);
         return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                 }
                 elseif($req->type == 'pending')
                 {
                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereIn('id',$data)->whereNotIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                     
                 }
                 elseif($req->inqsource)
                 {
                //    dd('call');

                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->where('inquirysource', $req->inqsource)->whereIn('id', $data)->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                     
                 }
                
                 elseif ($req->startdate && $req->enddate) {
                     $fromDate = Carbon::parse(request()->startdate)->format('Y-m-d');
                    
                     $toDate = Carbon::parse(request()->enddate)->format('Y-m-d');
                //////////////dd($fromDate);
                   $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereRaw(
                         "(created_at >= ? AND created_at <= ?)",
                         [$fromDate . " 00:00:00", $toDate . " 23:59:59"]
                     )->whereIn('id',$data)->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
 
                    // dd($data1);
                 }
                 else
                 {
                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereIn('id',$data)->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
               
 
                 }
             }


            return view('juniorlevel.inquiry')->with(['data' => $data, 'departments' => $departments, 'inquirysource'=> $inquirysource, 'users'=> $users]);
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function resolveinquiry(Request $request)
    {
        try {
            $fromuser = $request->fromuser;
            $departmentid = $request->departmentid;
            InquiryResolution::create(['inquiry_id' => $request->id, 'resolution' => $request->resolution]);
            $datecreated = InquiryTransactions::where(['inquiryid' => $request->id, 'touser' => auth()->user()->id])->first();
            // $datecreated = date_create($datecreated->created_at->format('Y-m-d'));
            // $resolvedate = date_create(date('Y-m-d'));
            // $diff=date_diff($datecreated,$resolvedate);

            $today = date('Y-m-d H:i:s');
            $date_of_quote = $datecreated->created_at->format('Y-m-d H:i:s');

            $date1 = strtotime($today);
            $date2 = strtotime($date_of_quote);

            $diff = abs($date1 - $date2);

            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365 * 60 * 60 * 24));

            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                / (30 * 60 * 60 * 24));

            $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            //echo $days;

            $getdays = getlimitdays(auth()->user()->id);
            if ($request->has('document')) {
                $foldername = 'resolve_document';
                $doc = $request->file('document')->store($foldername, 'public');

            }
            if ($days <= $getdays) {
                InquiryEvaluation::create(['document' => $doc, 'inquiryid' => $request->id, 'is_ontime' => 1, 'is_senior' => 0]);
            } else {
                InquiryEvaluation::create(['document' => $doc, 'inquiryid' => $request->id, 'is_ontime' => 0, 'is_senior' => 0]);
            }
            // InquiryTransactions::where('inquiryid', $request->id)->update(['is_resolved' => 1]);

            $inquiry = Inquiry::where('id', $request->id)->first();
            $createdbyuser = User::where('id', $fromuser)->first();
            $ceoemail = User::where('role', 4)->first();
            $caller = User::where('role', 1)->first();
            if ($ceoemail) {
                $ceo = $ceoemail->email;
                $emails = [auth()->user()->email, $ceo, $caller->email];
                $mobiles = [auth()->user()->mobile, $ceoemail->mobile, $caller->mobile];
                $toids = [auth()->user()->id, $ceoemail->id, $caller->id];
                foreach ($toids as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'An inquiry has been resolved. Please check the portal for <b> ' . $inquiry->uuid . ' </b> details.']);
                }
            } else {
                $emails = [auth()->user()->email];
                $mobiles = [auth()->user()->mobile];
            }
            // InquiryResolved::dispatch($emails, $mobiles, 'Inquiry', $request->name, $request->uuid, auth()->user()->name, $request->resolution);
            event(new InquiryResolvedEvent($inquiry->uuid));
            InquiryResolved::dispatchNow($emails, $mobiles, 'Inquiry', $createdbyuser->name, $inquiry->uuid, auth()->user()->name, $request->resolution);
            return redirect()->route('jinquiry');
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    public function transfer($text, $trans, $userid)
    {
        $transaction = Transition::findorFail($trans);
        // dd($userid);
        $createdbyuser = $transaction->complaint;
        $transferredto = User::where('id', $userid)->first();
        $update = $transaction->update(['is_transfered' => 1, 'transfer_comment' => $text]);
        // dd($transaction->touserrelation);
        if ($update) {
            $userdepartment = User::findorFail($userid)->department;
            Transition::create(['complaintid' => $transaction->complaintid, 'fromlevel' => $transaction->tolevel, 'tolevel' => $transferredto->role, 'fromuser' => auth()->user()->id, 'touser' => $userid, 'departmentid' => $userdepartment]);

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
                            array_push($toemails, auth()->user()->email);
                            break;

                        case 3:
                            $getuser = User::where('id', $userid)->first();
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
                            array_push($tosms, auth()->user()->mobile);
                            break;

                        case 3:
                            $getuser = User::where('id', $userid)->first();
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
                            array_push($tousers, auth()->user()->id);
                            break;

                        case 3:
                            $getuser = User::where('id', $userid)->first();
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
            // dd($tousers);
            if (count($tousers)) {
                foreach ($tousers as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $createdbyuser->title . ' </b> has been transferred.']);
                }
            }
            ComplaintTransferred::dispatchNow($toemails, $tosms, $createdbyuser->title, auth()->user()->name, $createdbyuser->customername, $transferredto->name, $text);
            event(new ComplaintTransfer($userid, $createdbyuser->title));
            return response()->json(['status' => 200, 'text' => $text, 'trans' => $trans, 'userid' => $userid]);
        } else {
            return response()->json(['status' => 201]);
        }
    }

    public function transferinquiry($text, $trans, $userid)
    {
        try {
            $transaction = InquiryTransactions::findorFail($trans);
            $createdbyuser = $transaction->inquiry;
            $transferredto = Inquiry::where('id', $userid)->first()->customername;
            $update = $transaction->update(['is_transfered' => 1, 'transfer_comment' => $text]);
            if ($update) {
                $userdepartment = User::findorFail($userid)->department;
                InquiryTransactions::create(['inquiryid' => $transaction->inquiryid, 'fromlevel' => $transaction->tolevel, 'tolevel' => $transaction->touserrelation->role, 'fromuser' => auth()->user()->id, 'touser' => $userid, 'departmentid' => $userdepartment]);

                $getemails = ActionTriggers::where('action_id', 2)->where('is_email', 1)->pluck('role');
                $getsms = ActionTriggers::where('action_id', 2)->where('is_sms', 1)->pluck('role');
                $toemails = [];
                $tosms = [];
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
                                array_push($toemails, auth()->user()->email);
                                break;

                            case 3:
                                $getuser = User::where('id', $userid)->first();
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
                                array_push($tosms, auth()->user()->mobile);
                                break;

                            case 3:
                                $getuser = User::where('id', $userid)->first();
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
                // dd($tosms);
                InquiryTransferred::dispatchNow($toemails, $tosms, $createdbyuser->title, auth()->user()->customername, $createdbyuser->customername, $transferredto, $text,auth()->user()->mobile);

                return response()->json(['status' => 200, 'text' => $text, 'trans' => $trans, 'userid' => $userid]);
            } else {
                return response()->json(['status' => 201]);
            }
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    public function resolvecomplaint(Request $request)
    {
        try {
                $mydata = Complaint::find($request->id);
                  $mydata->is_resolved = 1;
      
                  $mydata->save();
            $fromuser = $request->fromuser;
            $departmentid = $request->departmentid;
            Resolution::create(['complaint_id' => $request->id, 'resolution' => $request->resolution, 'user_id' => auth()->user()->id]);
            $datecreated = Transition::where(['complaintid' => $request->id, 'touser' => auth()->user()->id])->first();
            // dd($datecreated);
            // $datecreated = date_create($datecreated->created_at->format('Y-m-d'));
            // $resolvedate = date_create(date('Y-m-d'));
            // $diff=date_diff($datecreated,$resolvedate);

            $today = date('Y-m-d H:i:s');
            $date_of_quote = $datecreated->created_at->format('Y-m-d H:i:s');

            $date1 = strtotime($today);
            $date2 = strtotime($date_of_quote);

            $diff = abs($date1 - $date2);

            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365 * 60 * 60 * 24));

            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                / (30 * 60 * 60 * 24));

            $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            //echo $days;

            $getdays = getlimitdays(auth()->user()->id);
            $doc = '';
            if ($request->has('document')) {
                $foldername = 'resolve_document';
                $doc = $request->file('document')->store($foldername, 'public');

            }
            if ($days <= $getdays) {
                ComplaintEvaluation::create(['document' => $doc, 'complaintid' => $request->id, 'is_ontime' => 1, 'is_senior' => 0]);
            } else {
                ComplaintEvaluation::create(['document' => $doc, 'complaintid' => $request->id, 'is_ontime' => 0, 'is_senior' => 0]);
            }
           Transition::where('complaintid', $request->id)->update(['is_resolved' => 1]);
            $getemails = ActionTriggers::where('action_id', 5)->where('is_email', 1)->pluck('role');
            $getsms = ActionTriggers::where('action_id', 5)->where('is_sms', 1)->pluck('role');
            $complaint = Complaint::where('id', $request->id)->first();
            $createdbyuser = User::where('id', $fromuser)->first();
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
                            array_push($toemails, auth()->user()->email);
                            break;

                        case 3:
                            $getuser = User::where('role', $value)->where('department', $departmentid)->first();
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
                            array_push($tosms, auth()->user()->mobile);
                            break;

                        case 3:
                            $getuser = User::where('role', $value)->where('department', $departmentid)->first();
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
                            array_push($tousers, auth()->user()->id);
                            break;

                        case 3:
                            $getuser = User::where('role', $value)->where('department', $departmentid)->first();
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
            if (count($tousers)) {
                foreach ($tousers as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => '<b> ' . $complaint->title . ' </b> complaint has been resolved.']);
                }
            }
            ComplaintResolved::dispatchNow($toemails, $complaint->mobile, $complaint->title, $complaint->customername, $complaint->uuid, auth()->user()->name, $request->resolution);
            // RatingMail::dispatch($complaint->customername,$complaint->mobile, $complaint->email, );
                $this->sendsms($complaint->mobile, 'Dear ' . $complaint->customername . ' Your complaint has been resolved, Thanks Bikaji');

            event(new AppComplaintResolved($complaint->title));
            return redirect()->route('jcomplaint');
        } catch (\Throwable $th) {
            return redirect()->route('jcomplaint');
            //dd($th);
        }
    }
    // public function complainteresolve(Request $request)
    // {
    //     try {
    //         Transition::findorFail($request->compaintid)->update(['is_resolved' => 1, 'resolutionresponse' => $request->response]);
    //         return response()->json(['status' => 200]);
    //     } catch (\Throwable $th) {
    //         $this->customerr($th);
    //     }
    // }

    public function showprofile()
    {
        try {
            return view('juniorlevel.showprofile');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function changepassword()
    {
        try {
            return view('juniorlevel.changepassword');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
