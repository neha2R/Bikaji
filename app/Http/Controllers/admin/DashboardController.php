<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\ActionTriggers;
use App\Models\Configuration;
use App\Models\Inquiry;
use App\Models\InquiryTransactions;
use App\Models\Levels;
use App\Models\Logo;
use App\Models\NotificationChannels;
use App\Models\Transition;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Resolution;
use Illuminate\Support\Facades\Hash;

use App\Exports\OtherInquiryExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Department;
use App\Models\Complaint;
use App\Models\InquiryResolution;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalemployee = User::where('role', '!=', 0)->count();
              $departments = Department::with('users')->get();
                        $complaintid = Complaint::pluck('id')->all();
           // $totalgivieance = Transition::get()->unique('complaintid')->whereIn('complaintid',$complaintid)->count();
                     $totalgivieance = Complaint::get()->count();
                      $resolveid = Resolution::pluck('complaint_id')->all();
                      $resolvedcomplaintsonly = Transition::pluck('complaintid')->all();
            $inquiry = Inquiry::count();
            $resolveid = Resolution::pluck('complaint_id')->all();
            $highprioritycomplaint = Transition::where(['tolevel' => 3, 'is_resolved' => 0])->whereIn('complaintid',$complaintid)->whereNotIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
            $activecomplaint1 = Transition::where('is_resolved', 0)->whereIn('complaintid',$complaintid)->whereNotIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
                 $activecomplaint = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->whereNotIn('id',$resolveid)->get()->count();
                $activecomplaint=$activecomplaint + $activecomplaint1;

            //$activecomplaint = Transition::where('is_resolved', 0)->whereIn('complaintid',$complaintid)->get()->unique('complaintid')->count();
            //$resolvedcomplaint = Transition::where('is_resolved', 1)->whereIn('complaintid',$complaintid)->whereIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
             $resolvedcomplaint = Resolution::whereIn('complaint_id',$complaintid)->whereIn('complaint_id',$resolvedcomplaintsonly)->get()->unique('complaint_id')->count();
             $resolvedcomplaint1 = Resolution::whereIn('complaint_id',$complaintid)->whereNotIn('complaint_id',$resolvedcomplaintsonly)->get()->unique('complaint_id')->count();
                             $resolvedcomplaint=$resolvedcomplaint + $resolvedcomplaint1;
            $crossedtlcomplaint = Transition::where('is_resolved', 0)->whereIn('complaintid',$complaintid)->whereNotIn('complaintid',$resolveid)->whereHas('complaint', function ($q) {
                $getdays = complaintlimit();
                $q->whereDate('created_at', '<', Carbon::now()->subDays($getdays)->format('Y-m-d'));

            })->with('complaint')->orderBy('id', 'DESC')->get()->unique('complaintid')->count();

            
            $compalintstats = json_encode([$highprioritycomplaint, $activecomplaint, $resolvedcomplaint, $crossedtlcomplaint]);

            $compalintstatsdata = json_encode(['High Priority' => $highprioritycomplaint, 'Active Complaint' => $activecomplaint, 'Resolved Complaint' => $resolvedcomplaint, 'Crossed Timeline' => $crossedtlcomplaint]);

            // $highpriorityinquiry=InquiryTransactions::where(['tolevel' => 3, 'is_resolved' => 0])->count();
            $activeinquiry = InquiryTransactions::where('is_resolved', 0)->get()->unique('inquiryid')->count();
            $resolvedinquiry = InquiryTransactions::where('is_resolved', 1)->get()->unique('inquiryid')->count();

            $inquirystats = json_encode([$activeinquiry, $resolvedinquiry]);
            $inquirystatsdata = json_encode(['Active Inquiry' => $activeinquiry, 'Resolved Inquiry' => $resolvedinquiry]);
            return view('admin.dashboard', compact('totalemployee', 'totalgivieance', 'compalintstats', 'inquirystats', 'inquiry', 'compalintstatsdata', 'inquirystatsdata'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function profile()
    {
        try {
            return view('admin.profile');
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }
    public function resolvecomplaintadmin(Request $request)
    {
        //dd($request);
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
            Transition::where('complaintid', $request->id)->update(['is_resolved' => 1]);

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
            return redirect()->route('totalcomplaints');
        } catch (\Throwable $th) {
            return redirect()->route('totalcomplaints');
            //dd($th);
        }
    }
    public function updateprofile(Request $request)
    {
        try {
            $data = $request->except('_token', 'file');
            if (request()->has('file')) {
                $foldername = 'userprofile';
                $image = $request->file('file')->store($foldername, 'public');
                $data['profileimage'] = $image;
            }

            $update = User::findorFail(auth()->user()->id)->update($data);
            return redirect()->back()->with('success', 'Updated successfully!');

        } catch (\Throwable $th) {
            $this->customerr($th);
            return redirect()->back()->with('error', 'Something went wrong . Please try again!');

        }
    }

    public function notificationmethods()
    {
        try {
            $data = NotificationChannels::all();
            return view('admin.notificationmethod', compact('data'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function levels()
    {
        try {
            $data = Levels::all();
            $configuration = Configuration::all();
            return view('admin.levels', compact('data', 'configuration'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function configurationupdate(Request $request)
    {
        try {
            $update = Configuration::where(['from' => $request->from, 'to' => $request->to])->update(['days' => $request->days]);
            return redirect()->back();
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }
    public function changepassword()
    {
        try {
            return view('admin.changepassword');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function userchangepassword(Request $request)
    {
        try {
            $id = auth()->user()->id;
            $getuser = User::find($id);
            if (Hash::check($request->oldpass, $getuser->password)) {
                $password = Hash::make($request->conpass);
                $q = User::where('id', $id)->update(['password' => $password]);
                return redirect()->back()->with('msg', 'Password changed successfully.');
            } else {
                return redirect()->back()->with('message', 'Wrong old password. Please try again.');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function configurationactions()
    {
        try {
            $data = Action::all();
            return view('admin.configuration', compact('data'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function configureactionshandel(Request $request)
    {
        try {
            $email = $request->has('email') ? 1 : 0;
            $sms = $request->has('sms') ? 1 : 0;
            $whatsapp = $request->has('whatsapp') ? 1 : 0;
            ActionTriggers::where(['action_id' => $request->actionid, 'role' => $request->role])->update(['is_email' => $email, 'is_sms' => $sms, 'is_whatsapp' => $whatsapp]);
            return redirect()->back();
        } catch (\Throwable $th) {
            $this->customerr($th);

        }
    }

    public function uploadlogoview()
    {
        return view('admin.uploadlogo');
    }

    public function uploadlogo(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=100,max_height=62',
        ]);
        if ($request->has('file')) {
            $foldername = 'Logo';
            $image = $request->file('file')->store($foldername, 'public');
            $check = Logo::count();
            if ($check) {
                Logo::where('id', 1)->update(['logo' => $image]);
            } else {
                Logo::create(['logo' => $image]);
            }
            return redirect()->back()->with('msg', 'Logo uploaded successfully');
        }
    }
    public function totalcomplaints()
    {
        $data = Transition::query();
        $complaintid = Complaint::pluck('id')->all();
         $resolveid = Resolution::pluck('complaint_id')->all();                                         
        $resolvedcomplaintsonly = Transition::pluck('complaintid')->all();
        $resolvedcomplaintsonly = Transition::pluck('complaintid')->all();

       // $data = $data->orderBy('id', 'DESC')->get()->unique('complaintid');
    //  $data = $data->orderBy('id', 'DESC')->whereIn('complaintid',$complaintid)->get()->unique('complaintid');
    //  $data6 = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->get();
          //  $users = User::all();
            if (request()->has('employee')) {
                $emp = request()->get('employee');
                $data = $data->where('touser', $emp)->orderBy('id', 'DESC')->whereIn('complaintid',$complaintid)->get()->unique('complaintid');
                $data6=[];
            }
            else if (request()->has('startdate') && request()->has('enddate')) {
                $from = strtotime(request()->startdate);
                $from = date("Y-m-d", $from);
                $to = strtotime(request()->enddate);
                $to = date("Y-m-d", $to);
                // dd($from);
                $data=[];
                $data6 = Complaint::whereRaw("(created_at >= ? AND created_at <= ?)", [$from." 00:00:00", $to." 23:59:59"])->get();
            }
            else if (request()->has('type')) {
                if (request()->get('type') == 'resolved') {
                 //$data = $data->where('is_resolved', 1);
                             $data = $data->orderBy('id', 'DESC')->whereIn('complaintid',$complaintid)->whereIn('complaintid',$resolveid)->get()->unique('complaintid');
                 $data6 = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->whereIn('id',$resolveid)->get();
                  ////  $data = Resolution::whereIn('complaint_id',$complaintid)->whereIn('complaint_id',$resolvedcomplaintsonly)->get()->unique('complaint_id')->count();
                  /////  $data = Resolution::whereIn('complaint_id',$complaintid)->whereNotIn('complaint_id',$resolvedcomplaintsonly)->get()->unique('complaint_id')->count();
                }
                if (request()->get('type') == 'pending') {
                    $data = Transition::where('is_resolved', 0)->whereIn('complaintid',$complaintid)->whereNotIn('complaintid',$resolveid)->get()->unique('complaintid');
                 $data6 = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->whereNotIn('id',$resolveid)->get();

                }
                if (request()->get('type') == 'crossedtl') {

                    $data = $data->where('is_resolved', 0)->whereIn('complaintid',$complaintid)->whereNotIn('complaintid',$resolveid)->whereHas('complaint', function ($q) {
                        $getdays = complaintlimit();
                        $q->whereDate('created_at','<', Carbon::now()->subDays($getdays)->format('Y-m-d'));
                        
                    })->with('complaint');
                                     

                                $data = $data->orderBy('id', 'DESC')->get()->unique('complaintid');
                                   $data6 = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->whereNotIn('id',$resolveid)->whereDate('created_at','<', Carbon::now()->subDays(complaintlimit())->format('Y-m-d'))->get();
                }
            } 
             else if (request()->has('cmpsource')) {
               
                $cmpsource = request()->cmpsource;
                $data6 = Complaint::where('complaintsource',$cmpsource)->get();
                
            }
            else
            {
            $data6 = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->get();
          //$collection = collect($data2);
   // $merged     = $collection->merge($data1);
    //$data   = $merged->all();
            $data = $data->orderBy('id', 'DESC')->whereIn('complaintid',$complaintid)->get()->unique('complaintid');

            }
           
                        $users = User::all();

            return view('admin.total_complaints', compact('data', 'users','data6'));
    }
    public function totalinq(Request $req)
    {

        $resolvedinquiries = InquiryTransactions::where('is_resolved', 1)->get()->unique('inquiryid');
        $resolvedinquiryids = InquiryTransactions::where('is_resolved', 1)->pluck('inquiryid')->toArray();
        $resolveinquiry = InquiryResolution::pluck('inquiry_id')->all();

        $pendinginquiries = Inquiry::whereNotIn('id', $resolveinquiry)->get();

        if(isset($req->export))
        {
     $data=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
     return Excel::download(new OtherInquiryExport($data), 'Inquiries.xlsx');

        }
        elseif(isset($req->export2))
        {
     $data=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereNotIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
     return Excel::download(new OtherInquiryExport($data), 'Inquiries.xlsx');

        }
            $users = User::all();
            return view('admin.total_inq', compact('resolvedinquiries', 'pendinginquiries', 'users'));
    }
}
