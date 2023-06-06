<?php

namespace App\Http\Controllers\slevel;

use App\Events\ComplaintResolved as AppComplaintResolved;
use App\Events\InquiryResolvedEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ComplaintResolved;
use App\Jobs\InquiryResolved;
use App\Jobs\RatingMail;
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
use App\Traits\SmsTrait;
use App\User;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    use SmsTrait;
    public function index()
    {
        try {
          $complaintid = Complaint::pluck('id')->all();
            $resolveid = Resolution::pluck('complaint_id')->all();

            $countactive = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->get()->unique('complaintid')->count();
            $countresolved = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 1])->whereIn('complaintid',$complaintid)->whereIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
            $data = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->orderBy('id', 'DESC')->get()->unique('complaintid');
            $departments = Department::with('users')->get();
            return view('seniorlevel.dashboard', compact('countactive', 'countresolved', 'data', 'departments'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function complaint()
    {
        try {
            // dd(auth()->user()->id);
            $complaintid = Complaint::pluck('id')->all();
            $data = Transition::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->orderBy('id', 'DESC')->get()->unique('complaintid');
            $departments = Department::with('users')->get();
            return view('seniorlevel.complaint', compact('data', 'departments'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function resolvecomplaintslevel(Request $request)
    {
        try {
            // dd($request);
             $mydata = Complaint::find($request->id);
                  $mydata->is_resolved = 1;
      
                  $mydata->save();
            $fromuser = $request->fromuser;
            $departmentid = $request->departmentid;
            Resolution::create(['complaint_id' => $request->id, 'resolution' => $request->resolution, 'user_id' => auth()->user()->id]);
            $datecreated = Transition::where(['complaintid' => $request->id, 'touser' => auth()->user()->id])->first();
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
                ComplaintEvaluation::create(['document' => $doc, 'complaintid' => $request->id, 'is_ontime' => 1, 'is_senior' => 1]);
            } else {
                ComplaintEvaluation::create(['document' => $doc, 'complaintid' => $request->id, 'is_ontime' => 0, 'is_senior' => 1]);
            }

             Transition::where('complaintid', $request->id)->update(['is_resolved' => 1]);
            $getemails = ActionTriggers::where('action_id', 5)->where('is_email', 1)->pluck('role');
            $getsms = ActionTriggers::where('action_id', 5)->where('is_sms', 1)->pluck('role');
            $complaint = Complaint::where('id', $request->id)->first();
            $createdbyuser = User::where('id', $complaint->createdby)->first();
            $toemails = [];
            $tosms = [];
            $tousers = [];
            if (count($getemails)) {
                foreach ($getemails as $value) {
                    switch ($value) {
                        case 1:
                            $getuser = User::where('id', $complaint->createdby)->first();
                            if ($getuser) {
                                array_push($toemails, $getuser->email);
                            }
                            break;

                        case 2:
                            $getuser = User::where('id', $fromuser)->first();
                            if ($getuser) {
                                array_push($toemails, $getuser->email);
                            }
                            break;

                        case 3:
                            array_push($toemails, auth()->user()->email);
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
                            $getuser = User::where('id', $complaint->createdby)->first();
                            if ($getuser) {
                                array_push($tosms, $getuser->mobile);
                            }
                            break;

                        case 2:
                            $getuser = User::where('id', $fromuser)->first();
                            if ($getuser) {
                                array_push($tosms, $getuser->mobile);
                            }
                            break;

                        case 3:
                            array_push($tosms, auth()->user()->mobile);
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
                            $getuser = User::where('id', $complaint->createdby)->first();
                            if ($getuser) {
                                array_push($tousers, $getuser->id);
                            }
                            break;

                        case 2:
                            $getuser = User::where('id', $fromuser)->first();
                            if ($getuser) {
                                array_push($tousers, $getuser->id);
                            }
                            break;

                        case 3:
                            array_push($tousers, auth()->user()->id);
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
            ComplaintResolved::dispatchNow($toemails, $complaint->mobile, $complaint->title, $complaint->customername, $complaint->uuid, auth()->user()->name, $request->resolution,auth()->user()->mobile);
            RatingMail::dispatchNow($complaint->customername, $complaint->mobile, $complaint->email);

            event(new AppComplaintResolved($complaint->title));
            return redirect()->route('scomplaint');
        } catch (\Throwable $th) {
           // dd($th);
        }
    }

    public function inquiry()
    {
        try {
            $data = InquiryTransactions::where(['touser' => auth()->user()->id, 'is_transfered' => 0, 'is_resolved' => 0])->orderBy('id', 'DESC')->get();
            $departments = Department::with('users')->get();
            return view('seniorlevel.inquiry')->with(['data' => $data, 'departments' => $departments]);
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function resolveinquiryslevel(Request $request)
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
                InquiryEvaluation::create(['document' => $doc, 'inquiryid' => $request->id, 'is_ontime' => 1, 'is_senior' => 1]);
            } else {
                InquiryEvaluation::create(['document' => $doc, 'inquiryid' => $request->id, 'is_ontime' => 0, 'is_senior' => 1]);
            }
            // InquiryTransactions::where('inquiryid', $request->id)->update(['is_resolved' => 1]);

            $inquiry = Inquiry::where('id', $request->id)->first();
            $createdbyuser = User::where('id', $inquiry->createdby)->first();
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
            RatingMail::dispatchNow($inquiry->customername, $inquiry->mobile, $inquiry->email);

            event(new InquiryResolvedEvent($inquiry->uuid));
            InquiryResolved::dispatchNow($emails, $mobiles, 'Inquiry', $createdbyuser->name, $inquiry->uuid, auth()->user()->name, $request->resolution);
            return redirect()->route('sinquiry');
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    public function closecomplaints()
    {
        try {
            $resolveid = Resolution::where('user_id',auth()->user()->id)->pluck('complaint_id')->all();
          //  $resolveid = Resolution::pluck('complaint_id')->all();
            $data = Transition::where(['is_transfered' => 0,'is_resolved' => 1])->whereIn('complaintid',$resolveid)->orderBy('id', 'DESC')->get()->unique('complaintid');
            return view('seniorlevel.closecomplaints')->with('data', $data);
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function updateclosecomplaint(Request $request)
    {
        try {
            Transition::where('complaintid', $request->id)->update(['is_resolved' => 1]);
            $getcustomercontact = Complaint::find($request->id);
            $mobile = [$getcustomercontact->mobile];

            RatingMail::dispatchNow($getcustomercontact->customername, $getcustomercontact->mobile, $getcustomercontact->email);

            // $url = env('APP_URL').'/trackcomplaint';
            // $this->sendsms($mobile,'Your complaint "'.$getcustomercontact->title.'" has been resolved. You can check the status of your complaint using your mobile number at '.$url);
            return redirect()->back();
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function closeinquirys()
    {
        try {
            $data = InquiryTransactions::where(['touser' => auth()->user()->id, 'is_transfered' => 0,'is_resolved' => 1])->orderBy('id', 'DESC')->get()->unique('inquiryid');
            $frontinq = Inquiry::has('inquiryresolutionrelation')->get();
            return view('seniorlevel.closeinquirys')->with(['data' => $data, 'frontinq' => $frontinq]);
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function updatecloseinquirys(Request $request)
    {
        try {
            InquiryTransactions::where('inquiryid', $request->id)->update(['is_resolved' => 1]);
            return redirect()->back();
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function showprofile()
    {
        try {
            return view('seniorlevel.showprofile');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function changepassword()
    {
        try {
            return view('seniorlevel.changepassword');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
