<?php

namespace App\Http\Controllers\ceo;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Inquiry;
use App\Models\InquiryTransactions;
use App\Models\Transition;
use App\User;
use Carbon\Carbon;
use App\Models\Resolution;
use App\Models\Department;
use App\Models\InquiryType;
use App\Models\InquiryResolution;
use App\Exports\OtherInquiryExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
class DashboardController extends Controller
{
    public function index()
    {
        try {
         $complaintid = Complaint::pluck('id')->all();
                        $resolveid = Resolution::pluck('complaint_id')->all();
          /////  $totalcomplaints = Transition::whereIn('complaintid',$complaintid)->get()->unique('complaintid')->count();
          $totalcomplaints = Complaint::get()->count();
              $departments = Department::with('users')->get();
                                       $resolvedcomplaintsonly = Transition::pluck('complaintid')->all();
            $resolvedcomplaints = Transition::where('is_resolved', 1)->whereIn('complaintid',$complaintid)->whereIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
            $pendingcomplaints1 = Transition::where('is_resolved', 0)->whereIn('complaintid',$complaintid)->whereNotIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
                 $pendingcomplaints = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->whereNotIn('id',$resolveid)->get()->count();
                $pendingcomplaints=$pendingcomplaints + $pendingcomplaints1;
            $totalinquiries = Inquiry::count();
            $resolvedinquiries = InquiryTransactions::where('is_resolved', 1)->get()->unique('inquiryid')->count();
            $pendinginquiries = $totalinquiries - $resolvedinquiries;
            $highprioritycomplaints = Transition::where('tolevel', 3)->whereIn('complaintid',$complaintid)->where('is_resolved', 0)->count();
            $crossedtlcomplaints = Transition::where('is_resolved', 0)->whereIn('complaintid',$complaintid)->whereHas('complaint', function ($q) {
                $getdays = complaintlimit();
                $q->whereDate('created_at','<', Carbon::now()->subDays($getdays)->format('Y-m-d'));
                
            })->with('complaint')->orderBy('id', 'DESC')->get()->unique('complaintid')->count();
            return view('ceo.dashboard', compact('totalcomplaints', 'resolvedcomplaints', 'pendingcomplaints', 'totalinquiries', 'resolvedinquiries', 'pendinginquiries', 'highprioritycomplaints', 'crossedtlcomplaints'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function complaint()
    {
        try {
            $data = Transition::query();
                     $complaintid = Complaint::pluck('id')->all();
                                         $resolveid = Resolution::pluck('complaint_id')->all();                                           $resolvedcomplaintsonly = Transition::pluck('complaintid')->all();
                                         if (request()->has('employee')) {
                                            $emp = request()->get('employee');
                                            $data = $data->where('touser', $emp);
                                        }
                                        if (request()->has('startdate') && request()->has('enddate')) {
                                            $from = strtotime(request()->startdate);
                                            $from = date("Y-m-d", $from);
                                            $to = strtotime(request()->enddate);
                                            $to = date("Y-m-d", $to);
                                            ////dd($to);
                                            $resolvedcomplaints = $data->whereRaw("(updated_at >= ? AND updated_at <= ?)", [$from." 00:00:00", $to." 23:59:59"]);
                                        }
            if (request()->has('type')) {
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
            else
            {
            $data6 = Complaint::whereNotIn('id',$resolvedcomplaintsonly)->get();
          //$collection = collect($data2);
   // $merged     = $collection->merge($data1);
    //$data   = $merged->all();
            $data = $data->orderBy('id', 'DESC')->whereIn('complaintid',$complaintid)->get()->unique('complaintid');

            }
            

                        $users = User::all();

                                   return view('ceo.complaint', compact('data', 'users','data6'));
          
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function inquiry(Request $req)
    {
        $inquirysource = InquiryType::all();
        $data = Inquiry::all();
        $resolveinquiry = InquiryResolution::pluck('inquiry_id')->all();

        try {
            if (request()->has('startdate') && request()->has('enddate')) {
                $from = strtotime(request()->startdate);
                $from = date("Y-m-d", $from);
                $to = strtotime(request()->enddate);
                $to = date("Y-m-d", $to);

                $resolvedinquiries =   Inquiry::whereIn('id',$resolveinquiry)->whereRaw("(updated_at >= ? AND updated_at <= ?)", [$from . " 00:00:00", $to . " 23:59:59"])->get();
                $resolvedinquiryids = Inquiry::whereIn('id',$resolveinquiry)->pluck('id')->toArray();
                $pendinginquiries = Inquiry::whereNotIn('id', $resolvedinquiryids)->whereRaw("(created_at >= ? AND created_at <= ?)", [$from . " 00:00:00", $to . " 23:59:59"])->get();
            } 
            elseif ($req->type) {
           
                if ($req->type == 'resolved') {
                    $resolvedinquiries =   Inquiry::whereIn('id',$resolveinquiry)->get();

                    //////// $resolvedinquiries = InquiryTransactions::where('is_resolved', 1)->whereRaw("(updated_at >= ? AND updated_at <= ?)", [$from . " 00:00:00", $to . " 23:59:59"])->get()->unique('inquiryid');
                     // dd($resolvedinquiries);
                     $resolvedinquiryids = Inquiry::whereIn('id',$resolveinquiry)->pluck('id')->toArray();
                     $pendinginquiries = Inquiry::whereNotIn('id', $resolvedinquiryids)->get();
                    
                
                      }
                if ($req->type == 'pending') {
                    $resolvedinquiries =   Inquiry::whereIn('id',$resolveinquiry)->get();

                    //////// $resolvedinquiries = InquiryTransactions::where('is_resolved', 1)->whereRaw("(updated_at >= ? AND updated_at <= ?)", [$from . " 00:00:00", $to . " 23:59:59"])->get()->unique('inquiryid');
                     // dd($resolvedinquiries);
                     $resolvedinquiryids = Inquiry::whereIn('id',$resolveinquiry)->pluck('id')->toArray();
                     $pendinginquiries = Inquiry::whereNotIn('id', $resolvedinquiryids)->get();
                         ////dd($data);
                    if(isset($req->export))
                    {
                       ////dd('call');
                $data=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereNotIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
                return Excel::download(new OtherInquiryExport($data), 'Inquiries.xlsx');
           
                    }
                }
               
            } 
            else if ($req->inqsource) {
                $resolvedinquiries =   Inquiry::where('inquirysource',$req->inqsource)->whereIn('id',$resolveinquiry)->get();
                $resolvedinquiryids = Inquiry::where('inquirysource',$req->inqsource)->whereIn('id',$resolveinquiry)->pluck('id')->toArray();
                 $pendinginquiries = Inquiry::where('inquirysource',$req->inqsource)->whereNotIn('id', $resolvedinquiryids)->get();
               //// $data = Inquiry::where('inquirysource',$req->inqsource)->orderBy('id', 'desc')->get();
                
            }
            else if (request()->has('employee')) {
                $employee = request()->employee;
                $resolvedinquiries1 = InquiryTransactions::where('is_resolved', 1)->where('touser', $employee)->pluck('inquiryid')->toArray();
                $resolvedinquiryids = InquiryTransactions::where('is_resolved', 1)->pluck('inquiryid')->toArray();
                $pendinginquirieids = Inquiry::whereNotIn('id', $resolvedinquiryids)->pluck('id')->toArray();
                $pendinginquiries1 = InquiryTransactions::where('is_resolved', '0')->where('touser', $employee)->pluck('inquiryid')->toArray();
                $resolvedinquiries =   Inquiry::whereIn('id',$resolvedinquiries1)->get();
                $pendinginquiries = Inquiry::whereIn('id', $pendinginquiries1)->get();
              // dd($pendinginquiries);
            } else {
                $resolvedinquiries =   Inquiry::whereIn('id',$resolveinquiry)->get();
                  $resolvedinquiryids = Inquiry::whereIn('id',$resolveinquiry)->pluck('id')->toArray();
                 $pendinginquiries = Inquiry::whereNotIn('id', $resolvedinquiryids)->get();
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
                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereNotIn('id', $resolveinquiry)->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                     
                 }
                 elseif($req->inqsource)
                 {
                //    dd('call');

                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->where('inquirysource', $req->inqsource)->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                     
                 }
                 elseif($req->employee)
                 {
                //    dd('call');
                $data1empp = InquiryTransactions::where('touser', $req->employee)->pluck('inquiryid')->toArray();
                $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereIn('id', $data1empp)->orderBy('id', 'desc')->get();

                      return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                     
                 }
                 elseif ($req->startdate && $req->enddate) {
                     $fromDate = Carbon::parse(request()->startdate)->format('Y-m-d');
                    
                     $toDate = Carbon::parse(request()->enddate)->format('Y-m-d');
                //////////////dd($fromDate);
                   $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->whereRaw(
                         "(created_at >= ? AND created_at <= ?)",
                         [$fromDate . " 00:00:00", $toDate . " 23:59:59"]
                     )->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
 
                    // dd($data1);
                 }
                 else
                 {
                     $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->orderBy('id', 'desc')->get();
                     return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
               
 
                 }
             }
            $users = User::all();
            return view('ceo.inquiry', compact('resolvedinquiries', 'pendinginquiries', 'users','inquirysource'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function trackcomplaintform()
    {
        try {
            if (request()->has('refno')) {
                $refno = request()->get('refno');
                $getcomplaintid = Complaint::where('uuid', $refno)->first();
                if ($getcomplaintid) {
                    $complaintid = $getcomplaintid->id;
                    $gettransitions = Transition::where('complaintid', $complaintid)->get();
                } else {
                    $gettransitions = [];
                }
                return view('ceo.trackcomplaintform', compact('gettransitions'));
            }
            if (request()->has('mobileno')) {
                $mobileno = request()->get('mobileno');
                $getcomplaints = Complaint::where('mobile', $mobileno)->get();
                return view('ceo.trackcomplaintform', compact('getcomplaints'));
            }
            return view('ceo.trackcomplaintform');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function trackinquiryform()
    {
        try {
            if (request()->has('refno')) {
                $refno = request()->get('refno');
                $getinquiryid = Inquiry::where('uuid', $refno)->first();
                if ($getinquiryid) {
                    $inquiryid = $getinquiryid->id;
                    $gettransitions = InquiryTransactions::where('inquiryid', $inquiryid)->get();
                    // dd($gettransitions);
                } else {
                    $gettransitions = [];
                }
                return view('ceo.trackinquiryform', compact('gettransitions'));
            }
            if (request()->has('mobileno')) {
                $mobileno = request()->get('mobileno');
                $getinquires = Inquiry::where('contact', $mobileno)->get();
                return view('ceo.trackinquiryform', compact('getinquires'));
            }
            return view('ceo.trackinquiryform');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function showprofile()
    {
        try {
            return view('ceo.showprofile');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function changepassword()
    {
        try {
            return view('ceo.changepassword');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
