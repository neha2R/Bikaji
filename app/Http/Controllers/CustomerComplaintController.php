<?php

namespace App\Http\Controllers;

use App\Events\CustomerCreatedComplaint;
use App\Events\InquiryCreated;
use App\Jobs\CustomerComplaintFormNotification;
use App\Jobs\NewInquiryJobNotifications;
use App\Models\Complaint;
use App\Models\Inquiry;
use App\Models\InquiryTransactions;
use App\Models\Notification;
use App\Traits\SmsTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\NewComplaintNotifications;

class CustomerComplaintController extends Controller
{
    use SmsTrait;
    public function customercomplaintform()
    {
        try {
            return view('customercomplaint.customercomplaintform');
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function registercustomercomplaint(Request $request)
    {
        // dd($request);
        try {
            $customMessages = [
                'name.required' => 'Name is required',
                'details.required' => 'Detail is required',
                'mobile.required' => 'Mobile number is required',
                'title.required' => 'Title is required',
                'g-recaptcha-response.required' => 'Google Capcha is required',

            ];
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'details' => 'sometimes|required',
                'mobile' => 'sometimes|required|digits:10',
                'title' => 'sometimes|required',
                // 'g-recaptcha-response' => 'required',

            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [];
            $data['uuid'] = compaintnamehelper();
            $data['customername'] = $request->name;
            $data['details'] = $request->details;
            $data['mobile'] = $request->mobile;
            $data['title'] = $request->title;
            $data['email'] = $request->email;
            $data['pin'] = $request->pin;
            $data['address'] = $request->address;
            $data['complaintsource'] = '6';
            if ($request->has('file')) {
                $foldername = 'complaintimage';
                $image = $request->file('file')->store($foldername, 'public');
                $data['image'] = $image;
            }
            $create = Complaint::create($data);

            CustomerComplaintFormNotification::dispatchNow($data['uuid'], $request->name, $request->details, $request->mobile, $request->title, $request->email);
            $hremail = User::where('role','1')->first();
            NewComplaintNotifications::dispatchNow($data['uuid'],$request->name,$request->details,$hremail->mobile,$request->title,$hremail->email);
            //  dd($ret);
            // NewInquiryJobNotifications::dispatchNow($data['uuid'],$request->name,$request->details,$request->mobile,$request->title,$request->email,$request->mobile);
            $callerids = User::where('role', 1)->where('is_active', 1)->get()->pluck('id');
            if (count($callerids)) {
                foreach ($callerids as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new complaint <b> ' . $request->title . ' </b> has been registered by a customer. Please check the <b>Customer Complaint</b> section.']);
                }
            }
            event(new CustomerCreatedComplaint($request->title));
            $mobile = [$request->mobile];
            $url = env('APP_URL') . '/trackcomplaint';
            // $this->sendsms($mobile,'Your complaint "'.$request->title.'" has been registered succesfully. You can track your complaint using your mobile number at '.$url);
            return redirect()->back()->with(['msg' => 'Complaint registered successfully!']);
        } catch (\Throwable $th) {
            // dd($th);
            $this->customerr($th);
        }
    }

    public function customerinquiryform()
    {
        try {
            return view('customercomplaint.customerinquiryform');
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function registercustomerinquiry(Request $request)
    {
        try {
            $customMessages = [
                'name.required' => 'Name is required',
                'details.required' => 'Detail is required',
                'mobile.required' => 'Mobile number is required',
                'email.required' => 'Email is required',
                'state.required' => 'State is required',
                'pincode.required' => 'Pincode is required',
                'city.required' => 'City is required',
                'g-recaptcha-response.required' => 'Google Capcha is required',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'details' => 'sometimes|required',
                'mobile' => 'sometimes|required',
                'email' => 'sometimes|required',
                'state' => 'sometimes|required',
                'pincode' => 'sometimes|required',
                'city' => 'sometimes|required',
                'g-recaptcha-response' => 'required|captcha',

            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = [];
            $data['uuid'] = enquirynamehleper();
            $data['customername'] = $request->name;
            $data['details'] = $request->details;
            $data['contact'] = $request->mobile;
            $data['email'] = $request->email;
            $data['state'] = $request->state;
            $data['pincode'] = $request->pincode;
            $data['city'] = $request->city;
            $create = Inquiry::create($data);
            InquiryTransactions::create(['inquiryid' => $create->id, 'fromlevel' => 0, 'tolevel' => 0, 'fromuser' => 0, 'touser' => 0, 'departmentid' => 0]);
            $callerids = User::where('role', 1)->where('is_active', 1)->first();
            $ceoemail = User::where('role', 4)->first();
            if ($ceoemail) {
                $ceo = $ceoemail->email;
                $emails = [$callerids->email, $ceo];
                $mobiles = [$callerids->mobile, $ceoemail->mobile];
                $toids = [$callerids->id, $ceoemail->id];
                foreach ($toids as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new inquiry has been registered. Please check the portal for <b> ' . $create->uuid . ' </b> details.']);
                }
            } else {
                $emails = [$callerids->email];
                $mobiles = [$callerids->mobile];
            }
            NewInquiryJobNotifications::dispatchNow($create->uuid, $create->customername, $create->details, $mobiles, $create->title, $emails, $request->mobile);
            event(new InquiryCreated($create->uuid));
            $mobile = [$request->mobile];
            // $this->sendsms($mobile,'Your inquiry has been registered succesfully. Someone from our team will contact you soon.');
            return redirect()->back()->with(['msg' => 'Inquiry registered successfully!']);
        } catch (\Throwable $th) {
            // dd($th);
            $this->customerr($th);
        }
    }
}
