<?php

namespace App\Http\Controllers\frontoffice;

use App\Events\ComplaintCreated;
use App\Events\ComplaintResolved as AppComplaintResolved;
use App\Events\InquiryCreated;
use App\Events\InquiryResolvedEvent;
use App\Events\InquiryTransferred as AppInquiryTransferred;
use App\Http\Controllers\Controller;
use App\Jobs\ComplaintResolved;
use App\Jobs\CustomerComplaintFormNotification;
use App\Jobs\InquiryResolved;
use App\Jobs\InquiryTransferred;
use App\Jobs\NewComplaintNotifications;
use App\Jobs\NewInquiryJobNotifications;
use App\Models\ActionTriggers;
use App\Models\Complaint;
use App\Models\ComplaintEvaluation;
use App\Models\ComplaintSource;
use App\Models\Department;
use App\Models\Inquiry;
use App\Models\InquiryEvaluation;
use App\Models\InquiryResolution;
use App\Models\InquiryTransactions;
use App\Models\InquiryType;
use App\Models\Notification;
use App\Models\Resolution;
use App\Models\Transition;
use App\Traits\NewComplaintTrait;
use App\Traits\SmsTrait;
use App\User;
use App\Models\Category;
use App\Models\ComplaintAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Exports\OtherExport;
use App\Exports\OtherInquiryExport;

use Maatwebsite\Excel\Facades\Excel;
use File;

class DashboardController extends Controller
{
    use SmsTrait, NewComplaintTrait;
    public function index(Request $req)
    {
        try {
            $complaintsource = ComplaintSource::all();
            $inquirysource = InquiryType::all();
            $deparments = Department::has('users')->get();
            $enquirytype = InquiryType::all();
            $category = Category::all();
            
            if (request()->has('fromdate') && request()->has('todate')) {
                $fromDate = Carbon::parse(request()->fromdate)->format('Y-m-d');
               
                $toDate = Carbon::parse(request()->todate)->format('Y-m-d');
              // dd($toDate);
                $complaints = Complaint::whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [$fromDate . " 00:00:00", $toDate . " 23:59:59"]
                );
            }
            if (request()->has('type')) {
                $resolveid = Resolution::pluck('complaint_id')->all();
               
                if (request()->get('type') == 'resolved') {
                $complaints = Complaint::whereIn('id',$resolveid);
               
                if(isset($req->export))
                {
            //        dd('call');
     $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->whereIn('id',$resolveid)->where('createdby', auth()->user()->id)->orderBy('id', 'desc')->get();
     return Excel::download(new OtherExport($data), 'Complaints.xlsx');

                }
                      }
                if (request()->get('type') == 'pending') {
                    $complaints = $complaints->whereNotIn('id',$resolveid);
                    if(isset($req->export))
                    {
                //        dd('call');
         $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->whereNotIn('id',$resolveid)->where('createdby', auth()->user()->id)->orderBy('id', 'desc')->get();
         return Excel::download(new OtherExport($data), 'Complaints.xlsx');

                    }
                }
                if (request()->get('type') == 'crossedtl') {
                    $getdays = complaintlimit();

                    $complaints = Complaint::whereNotIn('id',$resolveid)->whereDate('created_at','<', Carbon::now()->subDays($getdays)->format('Y-m-d'));
                    if(isset($req->export))
                    {
                //        dd('call');
         $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->whereNotIn('id',$resolveid)->whereDate('created_at','<', Carbon::now()->subDays($getdays)->format('Y-m-d'))->where('createdby', auth()->user()->id)->orderBy('id', 'desc')->get();
         return Excel::download(new OtherExport($data), 'Complaints.xlsx');

                    }    
                }
            } 
            else if (request()->has('cmpsource')) {
               
                $cmpsource = request()->cmpsource;
                $complaints = Complaint::where('complaintsource',$cmpsource);
                
            }
            if(!empty($complaints))
            {
            $complaints = $complaints->orderBy('id', 'desc')->get()->unique('id');
            }
            else
            {
                $complaints = Complaint::orderBy('id', 'desc')->get()->unique('id');
 
            }
            if(isset($req->export))
            {
          // dd('call2222');
       //    dd(request()->has('fromdate'));
    ////   dd(request()->has('cmpsource'));
      // dd(request()->cmpsource);
       if (request()->has('cmpsource')) {
        $cmpsource = request()->cmpsource;
            if(!empty($cmpsource))
            {
        $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->where('complaintsource',$cmpsource)->orderBy('id', 'desc')->get();
        return Excel::download(new OtherExport($data), 'Complaints.xlsx');
            }
            else
            {
                $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->where('createdby', auth()->user()->id)->orderBy('id', 'desc')->get();
                return Excel::download(new OtherExport($data), 'Complaints.xlsx');
            
            }
          }
           if($req->fromdate!="" && $req->todate!="")
          {
                   // dd($req->export);

           //     dd($req->fromdate);
                    $fromDate = Carbon::parse(request()->fromdate)->format('Y-m-d');
                   // dd($fromDate);

                    $toDate = Carbon::parse(request()->todate)->format('Y-m-d');
                    $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->whereDate('created_at','>=',$fromDate)->whereDate('created_at','<=',$toDate)->where('createdby', auth()->user()->id)->orderBy('id', 'desc')->get();
                    return Excel::download(new OtherExport($data), 'Complaints.xlsx');

                }
         $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','createdby','title','is_resolved','email')->orderBy('id', 'desc')->get();
         return Excel::download(new OtherExport($data), 'Complaints.xlsx');

             
          

            }

            return view('frontoffice.dashboard', compact('enquirytype', 'complaintsource', 'deparments', 'complaints', 'inquirysource','category'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function createcomplaint(Request $request)
    {
        try {
            $customMessages = [
                'customername.required' => 'Name is required',
                'details.required' => 'Detail is required',
                'mobile.required' => 'Mobile number is required',
                'title.required' => 'Title is required',
            ];
            $validator = Validator::make($request->all(), [
                'customername' => 'sometimes|required',
                'details' => 'sometimes|required',
                'mobile' => 'sometimes|required|digits:10',
                'title' => 'sometimes|required',
            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator);
            }
            $data = [];
            $data['uuid'] = compaintnamehelper();
            $data['customername'] = $request->customername;
            $data['details'] = $request->details;
            $data['complaintsource'] = $request->cs;
            $data['complainttype'] = $request->ct;
            $data['createdby'] = auth()->user()->id;
            $data['mobile'] = isset($request->mobile)? $request->mobile : 'N/A';
            $data['title'] = $request->title;
            $data['email'] = isset($request->email)? $request->email : 'N/A';
              //  $fields = Input::get('result');

            $data['customer_type'] = $request->customer_type;
            $data['customer_address'] = $request->customer_address;
            $data['customer_city'] = $request->customer_city;
            $data['customer_state'] = $request->customer_state;
            $data['customer_invoice_no'] = $request->customer_invoice_no;
            $data['purchase_date'] = $request->purchase_date;
            $data['delivery_date'] = $request->delivery_date;
          ////  $data['product_category'] = $request->product_category;
            $data['product_name'] = $request->product_name;
            $data['batch_number'] = $request->batch_number;
            $data['sku'] = $request->sku;
            $data['mfg'] = $request->mfg;
            $data['production_facility'] = $request->production_facility;
            $data['risk_category'] =$request->inlineRadioOptions;
         //   dd($request->inlineRadioOptions);
            $data['complaint_type'] = $request->complaint_type;
             $data['product_categoryid'] = $request->pc;
             
            // if ($request->has('file')) {
            //     $foldername = 'complaintimage';
            //     $image = $request->file('file')->store($foldername, 'public');
            //     $data['image'] = $image;
            // }
          if ($request->has('batchfile')) {
                $foldername = 'complaintimage';
                $batchimage = $request->file('batchfile')->store($foldername, 'public');
                $data['batch_image'] = $batchimage;
            }
            $create = Complaint::create($data);
            if ($request->hasfile('media_name')) {



            //    $media->video_link = isset($request->video_link) ? $request->video_link : '';
               // $media->save();

                foreach ($request->file('media_name') as $key => $file) {

                    $type = '0';
                    // FeedMediaUploadJob::dispatchNow($file,$media->id,$type);
                    $name = $file->store('complaintimage', 'public');
                    $attachment = new ComplaintAttachment;
                    $attachment->complaint_id = $create->id;
                    $attachment->media_name = $name;
                    $attachment->media_type = $type;
                    // dd($attachment);
                    $attachment->save();
                }
            }
            if ($request->has('media_video')) {
                $videomimes = ['video/mp4']; //Add more mimes that you want to support
              //  dd($request->file('media_video'));
                foreach ($request->file('media_video') as $key => $videofile) {
//dd($videofile);
                if ($videofile->getClientOriginalName() != null) {
                    if (in_array($videofile->getMimeType(), $videomimes)) {
                        $type = '1';

                        $v_name = $videofile->store('complaintimage', 'public');

                        // $media = new FeedMedia;
                        // $media->feed_content_id = $data->id;
                        // $media->title = $request->title;
                        // $media->description=$request->description;
                        //$media->external_link=$request->external_link;
                       

                        $attachment = new ComplaintAttachment;
                        $attachment->complaint_id = $create->id;
                        $attachment->media_name = $v_name;
                        $attachment->media_type = $type;
                        $attachment->save();
                    }
                }
                }
            }
            if (isset($request->email)) {
               // CustomerComplaintFormNotification::dispatchNow($data['uuid'], $request->name, $request->details, $request->mobile, $request->title, $request->email);
            } else {
            //    $this->sendsms($request->mobile, 'Dear ' . $request->customername . ' Your complaint ' . $data["uuid"] . ' has been registered successfully. You can track your complaint using your mobile number at http://care.bikaji.com/trackcomplaint Bikaji Foods International Limited');

            }
            $usertosend = User::where(['department' => $request->ct, 'role' => 2])->first()->id;
            $transitionid = Transition::create(['complaintid' => $create->id, 'fromlevel' => 0, 'tolevel' => 0, 'fromuser' => auth()->user()->id, 'touser' => $usertosend, 'departmentid' => $request->ct]);
            $emails = $this->email($request->ct);
            $mobiles = $this->sms($request->ct);
            $users = $this->users($request->ct);
            if (count($users)) {
                foreach ($users as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $request->title . ' </b> has been registered.']);
                }
            }
        //    NewComplaintNotifications::dispatchNow($create->uuid, $create->customername, $create->details, $create->mobile, $create->title, $emails);
        //    event(new ComplaintCreated($create->title));
            $mobile = [$request->mobile];
            $url = env('APP_URL').'/trackcomplaint';
            $this->sendsms($mobile,'Your complaint "'.$request->title.'" has been registered succesfully. You can track your complaint using your mobile number at '.$url);
            return redirect()->back()->with('success', 'Complaint Created Succesfully!');
        } catch (\Throwable $th) {
           dd($th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong . Please try again!');
            $this->customerr($th);
        }
    }

    public function createinquiry(Request $request)
    {
        try {
            $customMessages = [
                'customername.required' => 'Name is required',
                'details.required' => 'Detail is required',
                'contact.required' => 'Mobile number is required',
                'email.required' => 'Email is required',
                'state.required' => 'State is required',
                'pincode.required' => 'Pincode is required',
                'city.required' => 'City is required',
            ];
            $validator = Validator::make($request->all(), [
                'customername' => 'sometimes|required',
                'details' => 'sometimes|required',
                'contact' => 'sometimes|required',
                'email' => 'sometimes|required',
                'state' => 'sometimes|required',
                'pincode' => 'sometimes|required',
                'city' => 'sometimes|required',
            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator)->with('status', 1);
            }
            $data = [];
            $data['uuid'] = enquirynamehleper();
            $data['customername'] = $request->customername;
            $data['contact'] = $request->contact;
            $data['email'] = $request->email;
            $data['details'] = $request->details;
            $data['city'] = $request->city;
            $data['state'] = $request->state;
            $data['pincode'] = $request->pincode;
            $data['createdby'] = auth()->user()->id;
            $data['inquirysource'] = $request->is;
            if ($request->has('file')) {
                $foldername = 'inquiryimage';
                $image = $request->file('file')->store($foldername, 'public');
                $data['image'] = $image;
            }
            $emails=$this->email($request->it);
            $mobiles=$this->sms($request->it);
            $create = Inquiry::create($data);
            $ceoemail = User::where('role', 4)->first();
            if ($ceoemail) {
                $ceo = $ceoemail->email;
                $emails = [auth()->user()->email, $ceo];
                $mobiles = [auth()->user()->mobile, $ceoemail->mobile];
                $toids = [auth()->user()->id, $ceoemail->id];
                foreach ($toids as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new inquiry has been registered. Please check the portal for <b> ' . $create->uuid . ' </b> details.']);
                }
            } else {
                $emails = [auth()->user()->email];
                $mobiles = [auth()->user()->mobile];
            }

            // $touser = User::where(['department'=>$request->it,'role'=>2])->first()->id;
            InquiryTransactions::create(['inquiryid' => $create->id, 'fromlevel' => 0, 'tolevel' => 0, 'fromuser' => auth()->user()->id, 'touser' => auth()->user()->id, 'departmentid' => auth()->user()->department]);
            NewInquiryJobNotifications::dispatchNow($create->uuid, $create->customername, $create->details, $mobiles, $create->title, $emails, $request->contact);
            event(new InquiryCreated($create->uuid));
            return redirect()->back()->with('success', 'Inquary Created Succesfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong . Please try again!');
            $this->customerr($th);
        }
    }

    public function reports()
    {
        $totalcomplaints = Complaint::orderBy('id', 'DESC')->get()->count();
        $totalinquiries = Inquiry::count();
         $complaintid = Complaint::pluck('id')->all();
         $resolveid = Resolution::pluck('complaint_id')->all();
                $resolvedcomplaintsonly = Transition::pluck('complaintid')->all();
      //$resolvedcomplaints = Transition::whereIn('complaintid',$complaintid)->whereIn('complaintid',$resolveid)->get()->unique('complaintid')->count();
        $resolvedcomplaints =Complaint::whereIn('id',$resolveid) ->count();

//$totalcomplaints1 = Complaint::whereNull('createdby')->orderBy('id', 'DESC')->get()->count();
       // $resolvedcomplaints1 = Resolution::whereIn('complaint_id',$complaintid)->whereNotIn('complaint_id',$resolvedcomplaintsonly)->get()->unique('complaint_id')->count();
        $resolvedinquiries = InquiryTransactions::where('is_resolved', 1)->get()->unique('inquiryid')->count();
        return view('frontoffice.reports', compact('totalcomplaints', 'totalinquiries', 'resolvedcomplaints', 'resolvedinquiries'));
    }

    public function inquiry(Request $req)
    {

        $inquirysource = InquiryType::all();
        $data = Inquiry::all();
        $resolveinquiry = InquiryResolution::pluck('inquiry_id')->all();

       // $data = InquiryTransactions::where(['is_transfered' => 0, 'is_resolved' => 0])->orderBy('id', 'DESC')->get()->unique('inquiryid');
        if ($req->fromdate && $req->todate) {
            $fromDate = Carbon::parse(request()->fromdate)->format('Y-m-d');
           
            $toDate = Carbon::parse(request()->todate)->format('Y-m-d');
       //////////////dd($fromDate);
            $data = Inquiry::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [$fromDate . " 00:00:00", $toDate . " 23:59:59"]
            )->orderBy('id', 'desc')->get();
           // dd($data1);
        }
        elseif ($req->type) {
           
            if ($req->type == 'resolved') {
            $data = Inquiry::whereIn('id',$resolveinquiry)->orderBy('id', 'desc')->get();
           
            
                  }
            if ($req->type == 'pending') {
                $data = Inquiry::whereNotIn('id',$resolveinquiry)->orderBy('id', 'desc')->get();
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
               
            $inqsource = request()->inqsource;
            $data = Inquiry::where('inquirysource',$inqsource)->orderBy('id', 'desc')->get();
            
        }
        if(isset($req->export))
            {
             //// dd('call');
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
                    $data12=Inquiry::select('uuid','customername','contact','details','inquirysource','created_at','createdby','email')->where('inquirysource', $req->inqsource)->orderBy('id', 'desc')->get();
                    return Excel::download(new OtherInquiryExport($data12), 'Inquiries.xlsx');
                    
                }
                elseif ($req->fromdate && $req->todate) {
                    $fromDate = Carbon::parse(request()->fromdate)->format('Y-m-d');
                   
                    $toDate = Carbon::parse(request()->todate)->format('Y-m-d');
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
        return view('frontoffice.inquiry', compact('data', 'users','inquirysource'));
    }

    public function customercomplaintslist(Request $req)
    {
        try {
            $departments = Department::has('users')->get();
            $data = Complaint::whereNull('createdby')->orderBy('id', 'DESC')->get();

            if(isset($req->export))
            {

         $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->WhereNull('createdby')->orderBy('id', 'desc')->get();
         return Excel::download(new OtherExport($data), 'Complaints.xlsx');

            }
            return view('frontoffice.customercomplaints', compact('data', 'departments'));
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function addcustomercomplaint(Request $request)
    {
   
        try {
            $complaint = Complaint::where('id', $request->complaintid)->first();
            Complaint::where('id', $request->complaintid)->update(['createdby' => auth()->user()->id, 'complainttype' => $request->ct]);
            $usertosend = User::where(['department' => $request->ct, 'role' => 2])->first()->id;

            $usertosendcheck = Transition::where(['touser' => $usertosend])->where('is_resolved', '0')->count();

            if (isset($usertosendcheck)) {
              $usertosend2 = User::where(['department' => $request->ct, 'role' => 2])->where('id', '!=', $usertosend)->first('id');
          
                if (isset($usertosend2)) {
                    $usertosend = User::where(['department' => $request->ct, 'role' => 2])->where('id', '!=', $usertosend)->first()->id;
                } else {
                    $usertosend = $usertosend;

                }
            }
            if(isset($req->export))
            {
         $data=Complaint::select('uuid','customername','mobile','details','complainttype','complaintsource','created_at','title','is_resolved','email')->WhereNull('createdby')->orderBy('id', 'desc')->get();
         return Excel::download(new OtherExport($data), 'Complaints.xlsx');

            }
            Transition::create(['complaintid' => $request->complaintid, 'fromlevel' => 0, 'tolevel' => 0, 'fromuser' => auth()->user()->id, 'touser' => $usertosend, 'departmentid' => $request->ct]);
            $emails = $this->email($request->ct);
            $mobiles = $this->sms($request->ct);
            $users = $this->users($request->ct);
            if (count($users)) {
                foreach ($users as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $complaint->title . ' </b> has been registered.']);
                }
            }
            NewComplaintNotifications::dispatchNow($complaint->uuid, $complaint->customername, $complaint->details, $complaint->mobile, $complaint->title, $emails);
            event(new ComplaintCreated($complaint->title));
            return redirect()->back();
        } catch (\Throwable $th) {
            // dd($th);
            $this->customerr($th);
        }
    }
    public function resolvecomplaint(Request $request)
    {

        $mydata = Complaint::find($request->id);

        Resolution::create(['complaint_id' => $request->id, 'resolution' => $request->resolution,'user_id' => auth()->user()->id]);
        $datecreated = Transition::where(['complaintid' => $request->id, 'fromuser' => auth()->user()->id])->first();
        // $datecreated = date_create($datecreated->created_at->format('Y-m-d'));
        // $resolvedate = date_create(date('Y-m-d'));
        // $diff=date_diff($datecreated,$resolvedate);
        if (empty($datecreated)) {
            $today = date('Y-m-d H:i:s');
            $date_of_quote = $mydata->created_at->format('Y-m-d H:i:s');
        } else {
            $today = date('Y-m-d H:i:s');
            $date_of_quote = $datecreated->created_at->format('Y-m-d H:i:s');
        }
        $mydata->is_resolved = 1;
      
        $mydata->save();
    
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
        $toemails = [auth()->user()->email];
        $tosms = [auth()->user()->mobile];
        $tousers = [auth()->user()->id];
        if (count($getemails)) {
            foreach ($getemails as $key => $value) {
                if ($value == 4) {
                    $getuser = User::where('role', $value)->first();
                    if ($getuser) {
                        array_push($toemails, $getuser->email);
                        array_push($tousers, $getuser->id);
                    }
                }
            }
        }
        if (count($getsms)) {
            foreach ($getsms as $key => $value) {
                if ($value == 4) {
                    $getuser = User::where('role', $value)->first();
                    if ($getuser) {
                        array_push($tosms, $getuser->mobile);
                    }
                }
            }
        }
        if (count($tousers)) {
            foreach ($tousers as $key => $value) {
                Notification::create(['userid' => $value, 'message' => '<b> ' . $request->title . ' </b> complaint has been resolved.']);
            }
        }
        $compData = Complaint::find($request->id);
        ComplaintResolved::dispatch($toemails, $compData->mobile, $request->title, $request->name, $request->uuid, auth()->user()->name, $request->resolution);
        // RatingMail::dispatch($request->name,$compData->mobile, $compData->email, );
$this->sendsms($compData->mobile, 'Dear ' . $compData->customername . ' Your complaint has been resolved, Thanks Bikaji');
        event(new AppComplaintResolved($request->title));
        return redirect()->back();
    }
    public function resolveinquiry(Request $request)
    {
        //    Inquiry::findorFail($request->id)->update(['is_resolved'=>1]);
        InquiryResolution::create(['inquiry_id' => $request->id, 'resolution' => $request->resolution]);
        $datecreated = InquiryTransactions::where(['inquiryid' => $request->id])->first();
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
        $ceoemail = User::where('role', 4)->first();
        if ($ceoemail) {
            $ceo = $ceoemail->email;
            $emails = [auth()->user()->email, $ceo];
            $mobiles = [auth()->user()->mobile, $ceoemail->mobile];
            $toids = [auth()->user()->id, $ceoemail->id];
            foreach ($toids as $key => $value) {
                Notification::create(['userid' => $value, 'message' => 'An inquiry has been resolved. Please check the portal for <b> ' . $request->uuid . ' </b> details.']);
            }
        } else {
            $emails = [auth()->user()->email];
            $mobiles = [auth()->user()->mobile];
        }
        InquiryResolved::dispatch($emails, $mobiles, 'Inquiry', $request->name, $request->uuid, auth()->user()->name, $request->resolution);
        event(new InquiryResolvedEvent($request->uuid));
        return redirect()->back();
    }

    public function transferinquiry($text, $trans, $userid)
    {
        try {
            $transaction = InquiryTransactions::where('inquiryid', $trans)->first();
            $createdbyuser = auth()->user()->id;
            $transferredto = User::find($userid);
            $update = $transaction->update(['is_transfered' => 1, 'transfer_comment' => $text, 'fromuser' => auth()->user()->id, 'touser' => auth()->user()->id, 'departmentid' => auth()->user()->department]);
            $updatecreatedby = Inquiry::where('id', $trans)->update(['createdby' => auth()->user()->id]);
            if ($update) {
                $userdepartment = User::findorFail($userid)->department;
                InquiryTransactions::create(['inquiryid' => $transaction->inquiryid, 'fromlevel' => 0, 'tolevel' => $transferredto->role, 'fromuser' => auth()->user()->id, 'touser' => $userid, 'departmentid' => $userdepartment]);

                $getemails = ActionTriggers::where('action_id', 2)->where('is_email', 1)->pluck('role');
                $getsms = ActionTriggers::where('action_id', 2)->where('is_sms', 1)->pluck('role');
                $toemails = [];
                $tosms = [];
                if (count($getemails)) {
                    foreach ($getemails as $value) {
                        switch ($value) {
                            case 1:
                                $getuser = User::where('id', $createdbyuser)->first();
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
                                $getuser = User::where('id', $createdbyuser)->first();
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
                $inquirycreatedby = Inquiry::where('id', $trans)->first()->customername;
                InquiryTransferred::dispatchNow($toemails, $tosms, 'Inquiry', auth()->user()->name, $inquirycreatedby, $transferredto->name, $text);
                event(new AppInquiryTransferred($userid));
                Notification::create(['userid' => $userid, 'message' => 'A new inquiry has been transferred to your panel.']);
                return response()->json(['status' => 200, 'text' => $text, 'trans' => $trans, 'userid' => $userid]);
            } else {
                return response()->json(['status' => 201]);
            }
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    public function showprofile()
    {
        try {
            return view('frontoffice.editprofile');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function changepassword()
    {
        try {
            return view('frontoffice.changepassword');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function showcomplaint($id)
    {
        try {
            $comp = Complaint::find($id);
            $complaintsource = ComplaintSource::all();
            $inquirysource = InquiryType::all();
            $deparments = Department::has('users')->get();
            $enquirytype = InquiryType::all();
             $category = Category::all();
             //dd('call');

           $complaintattachment = ComplaintAttachment::where('complaint_id', $id)->where('media_type', '0')->orderByDesc('id')->get();
          
           $complaintattachmentvideo = ComplaintAttachment::where('complaint_id', $id)->where('media_type', '1')->orderByDesc('id')->get();
            return view('frontoffice.editcomplaint', ['inquirysource' => $inquirysource, 'deparments' => $deparments, 'enquirytype' => $enquirytype, 'complaintsource' => $complaintsource, 'category' => $category, 'comp' => $comp, 'complaintattachment' => $complaintattachment, 'complaintattachmentvideo' => $complaintattachmentvideo]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function editcomplaint(Request $request, $id)
    {
        try {
            $customMessages = [
                'customername.required' => 'Name is required',
                'details.required' => 'Detail is required',
                'mobile.required' => 'Mobile number is required',
                'title.required' => 'Title is required',
            ];
            $validator = Validator::make($request->all(), [
                'customername' => 'sometimes|required',
                'details' => 'sometimes|required',
                'mobile' => 'sometimes|required',
                'title' => 'sometimes|required',
            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator);
            }
            $data = [];
            $data['uuid'] = compaintnamehelper();
            $data['customername'] = $request->customername;
            $data['details'] = $request->details;
            $data['complaintsource'] = $request->cs;
            $data['complainttype'] = $request->ct;
            // $data['createdby'] = auth()->user()->id;
            $data['mobile'] = isset($request->mobile)? $request->mobile : 'N/A';
            $data['title'] = $request->title;
            $data['email'] = isset($request->email)? $request->email : 'N/A';
            $data['customer_type'] = $request->customer_type;
            $data['customer_address'] = $request->customer_address;
            $data['customer_city'] = $request->customer_city;
            $data['customer_state'] = $request->customer_state;
            $data['customer_invoice_no'] = $request->customer_invoice_no;
            $data['purchase_date'] = $request->purchase_date;
            $data['delivery_date'] = $request->delivery_date;
            $data['product_category'] = $request->product_category;
            $data['product_name'] = $request->product_name;
            $data['batch_number'] = $request->batch_number;
            $data['sku'] = $request->sku;
            $data['mfg'] = $request->mfg;
            $data['production_facility'] = $request->production_facility;
            $data['risk_category'] =$request->inlineRadioOptions;
            $data['complaint_type'] = $request->complaint_type;
            $data['product_categoryid'] = $request->pc;
         
            // if ($request->has('file')) {
            //     $foldername = 'complaintimage';
            //     $image = $request->file('file')->store($foldername, 'public');
            //     $data['image'] = $image;
            // }
             if ($request->has('batchfile')) {
                $foldername = 'complaintimage';
                $batchimage = $request->file('batchfile')->store($foldername, 'public');
                $data['batch_image'] = $batchimage;
            }
            $update = Complaint::where('id', $id)
                ->update($data);
                if (ComplaintAttachment::where('complaint_id', $id)->first()) {
                    ComplaintAttachment::where('complaint_id', $id)->delete();
                 //   dd($request->old_images);
                    if (isset($request->old_images)) {
                        foreach ($request->old_images as $image) {
                            if(File::exists($image)) {
                                File::delete($image);
                              }
                            $images = new ComplaintAttachment;
                            $images->complaint_id = $id;
                            $images->media_type = '0';
                            $images->media_name = $image;
                            $images->save();
                        }
                    }
                    if (isset($request->old_videos)) {
                        foreach ($request->old_videos as $video) {
                            if(File::exists($video)) {
                                File::delete($video);
                              }
                            $images = new ComplaintAttachment;
                            $images->complaint_id = $id;
                            $images->media_type = '1';
                            $images->media_name = $video;
                            $images->save();
                        }
                    }
                }
                if ($request->hasfile('media_name')) {



                    //    $media->video_link = isset($request->video_link) ? $request->video_link : '';
                       // $media->save();
        
                        foreach ($request->file('media_name') as $key => $file) {
        
                            $type = '0';
                            // FeedMediaUploadJob::dispatchNow($file,$media->id,$type);
                            $name = $file->store('complaintimage', 'public');
                            $attachment = new ComplaintAttachment;
                            $attachment->complaint_id = $id;
                            $attachment->media_name = $name;
                            $attachment->media_type = $type;
                            // dd($attachment);
                            $attachment->save();
                        }
                    }
                    if ($request->has('media_video')) {
                        $videomimes = ['video/mp4']; //Add more mimes that you want to support
                      //  dd($request->file('media_video'));
                        foreach ($request->file('media_video') as $key => $videofile) {
                         //  dd($videofile);
                        if ($videofile->getClientOriginalName() != null) {
                            if (in_array($videofile->getMimeType(), $videomimes)) {
                                $type = '1';
        
                                $v_name = $videofile->store('complaintimage', 'public');
        
                                // $media = new FeedMedia;
                                // $media->feed_content_id = $data->id;
                                // $media->title = $request->title;
                                // $media->description=$request->description;
                                //$media->external_link=$request->external_link;
                               
        
                                $attachment = new ComplaintAttachment;
                                $attachment->complaint_id = $id;
                                $attachment->media_name = $v_name;
                                $attachment->media_type = $type;
                                $attachment->save();
                            }
                        }
                        }
                    }
            // return redirect()->route('frontofficedashboard')->with(['Msg' => 'Complaint updated successfully!']);
            return redirect()->route('frontofficedashboard')->with('success', 'Complaint Updated Succesfully!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('frontofficedashboard')->with('error', 'Something went wrong !');
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
                return view('frontoffice.trackcomplaintform', compact('gettransitions'));
            }
            if (request()->has('mobileno')) {
                $mobileno = request()->get('mobileno');
                $getcomplaints = Complaint::where('mobile', $mobileno)->get();
                return view('frontoffice.trackcomplaintform', compact('getcomplaints'));
            }
            return view('frontoffice.trackcomplaintform');
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
                return view('frontoffice.trackinquiryform', compact('gettransitions'));
            }
            if (request()->has('mobileno')) {
                $mobileno = request()->get('mobileno');
                $getinquires = Inquiry::where('contact', $mobileno)->get();
                return view('frontoffice.trackinquiryform', compact('getinquires'));
            }
            return view('frontoffice.trackinquiryform');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function whatsappTest()
    {
$message ='Dear Sir/Ma\'am,

A new enquiry No. {{1}} has been registered in the system.

Please check the Bikaji Grievance Management Portal for faster resolution by clicking on this link: http://care.bikaji.com/auth/login';

//$this->sendWhatsappMessage('94686358',$message,$header,$footer);
$header='New Enquiry Alert: Bikaji Grievance manegement portal';
$footer='Bikaji Foods International Limited';
       $this->whatsappMessage($message,'9468636358',$header,$footer);
    }





    public static function newWhatsappMessageBroadcastHandle()
    {

        
        $status;
        $on_whatsapp;
        $mobileNumber = '8107721177';
       
        $en_message='Hello,

An enquiry has been transferred to you from another department/section, as it was related to you.
You can check the enquiry at this link http://care.bikaji.com/auth/login by logging in.';
        $isTemplate='true';
        $response = Http::get('https://media.smsgupshup.com/GatewayAPI/rest', [
            'userid' => '2000198849',
            'password' => '*Us9jRXz',
            'phone_number' => '91'.$mobileNumber,
            'method' => 'OPT_IN',
            'auth_scheme' => 'plain',
            'v' => 1.1,
            'channel' => 'whatsapp',
            'format' => 'json',
        ]);
        $data = json_decode($response->body());
        $status = $data->response->status;
        
       // dd($data);
        if ($status == 'success')
        {


            
            if($en_header == null && $en_footer == null)
            { 
              
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://media.smsgupshup.com/GatewayAPI/rest',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'method=SendMessage&userid=2000198849&password=*Us9jRXz&msg='.$en_message.'&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to='.$mobileNumber.'&isTemplate='.$isTemplate,
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),));
                $response = curl_exec($curl);
                    dd($response);
                curl_close($curl);
              //  dd("dkjfjkdsf");
                dd($response,'hekko');
            }
            else
            {
                
                $curl = curl_init();
             //   dd($isTemplate);
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://media.smsgupshup.com/GatewayAPI/rest',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'method=SendMessage&userid=2000198849&password=*Us9jRXz&msg='.$en_message.'&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to='.$mobileNumber.'&isTemplate='.$isTemplate.'&footer='.$en_footer.'&header='.$en_header,
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),));
                $response = curl_exec($curl);
    
                curl_close($curl);
                $data = json_decode($response);
                dd($response);
                $status = $data->response->status;
               // dd($status);

            }

            // $input = ['mobile_number'=>$mobileNumber,'message'=>$en_message,'status'=>$status,'on_whatsapp'=>1];

            // //dd($input);
            //   $message = rawurldecode($en_message);
            //  WhatsappMessage::create(['mobile_number'=>$mobileNumber,'message'=>$message,'status'=>$status,'on_whatsapp'=>1]);

        }
    }

}
