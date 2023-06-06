<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Inquiry;
use App\Models\InquiryTransactions;
use App\Models\Transition;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function trackcomplaintview(){
        try {
            if (request()->has('mobileno')) {
                $mobileno = request()->get('mobileno');
                $getcomplaints = Complaint::where('mobile', $mobileno)->get();
                return view('track.trackcomplaint', compact('getcomplaints'));
            }
            if (request()->has('refno')) {
                $refno = request()->get('refno');
                $getcomplaintid = Complaint::where('uuid', $refno)->first();
                if ($getcomplaintid) {
                    $complaintid = $getcomplaintid->id;
                    $gettransitions = Transition::where('complaintid', $complaintid)->orderBy('id', 'DESC')->first();
                    return view('track.complaintstatus', compact('gettransitions'));
                } else {
                    return redirect()->back()->with('message', 'Invalid Reference. Please try again.');
                }
            }
            return view('track.trackcomplaint');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function trackcomplaint(){
        try {
            if (request()->has('mobileno')) {
                $mobileno = request()->get('mobileno');
                $getcomplaints = Complaint::where('mobile', $mobileno)->get();
                dd($getcomplaints);
                return view('track.trackcomplaint', compact('getcomplaints'));
            }
            if (request()->has('refno')) {
                $refno = request()->get('refno');
                $getcomplaintid = Complaint::where('uuid', $refno)->first();
                if ($getcomplaintid) {
                    $complaintid = $getcomplaintid->id;
                    $gettransitions = Transition::where('complaintid', $complaintid)->orderBy('id', 'DESC')->first();
                    return view('track.complaintstatus', compact('gettransitions'));
                } else {
                    return redirect()->back()->with('message', 'Invalid Reference. Please try again.');
                }
            }
             
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function trackinquiryview(){
        try {
            return view('track.trackinquiry');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function trackinquiry(Request $request){
        try {
            $refno = $request->refno;
            $getinquiryid = Inquiry::where('uuid', $refno)->first();
            if ($getinquiryid) {
                $inquiryid = $getinquiryid->id;
                $gettransitions = InquiryTransactions::where('inquiryid', $inquiryid)->orderBy('id', 'DESC')->first();
                return view('track.inquirystatus', compact('gettransitions'));
            } else {
                return redirect()->back()->with('message', 'Invalid Reference. Please try again.');
            }
            
        } catch (\Throwable $th) {
            // dd($th);
        }
    }
}
