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
use App\Models\Department;
use App\Models\Contact;
use App\Models\ComplaintAttachment;

class CustomerComplaintController extends Controller
{
    use SmsTrait;
    public function customercomplaintform()
    {
        try {
            $deparments = Department::has('users')->orderBy('id', 'desc')->get();

            return view('customercomplaint.customercomplaintform' , ['deparments' => $deparments]);
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }
    public function getfeedback()
    {
        try {
          //  $deparments = Department::has('users')->orderBy('id', 'desc')->get();

            return view('contact');
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }
    public function feedback(Request $request)
    {
       // dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10|numeric',
            'complaint' => 'required'
        ]);
  
        Contact::create($request->all());
  
        return redirect()->back()
                         ->with(['success' => 'Thank you for your feedback.']);
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
                'ct.required' => 'Complaint type is required',
                'batch_number.required' => 'batch_number is required',
                'g-recaptcha-response.required' => 'Google Capcha is required',

            ];
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'details' => 'sometimes|required',
                'mobile' => 'sometimes|required|digits:10',
                'title' => 'sometimes|required',
                'ct' => 'sometimes|required',
                'batch_number' => 'sometimes|required',
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
            $data['complainttype'] = $request->ct;
            $data['batch_number'] = $request->batch_number;

            $data['address'] = $request->address;
            $data['complaintsource'] = '6';
            $create = Complaint::create($data);

           

           /* if ($request->has('file')) {
                $foldername = 'complaintimage';
                $image = $request->file('file')->store($foldername, 'public');
                $data['image'] = $image;
            } */
            if ($request->hasfile('myFile')) {
                foreach ($request->file('myFile') as $key => $file) {
                    list($width, $height) = getimagesize($file);
                   if($file->getMimeType()=='image/png') 
                   {
                    $myImage = imagecreatefrompng(realpath($file));
                   }
                   else
                   {
                    $myImage = imagecreatefromjpeg(realpath($file));


                   }
                   /* if ($width > $height) {
                        $y = 0;
                        $x = ($width - $height) / 2;
                        $smallestSide = $height;
                      } else {
                        $x = 0;
                        $y = ($height - $width) / 2;
                        $smallestSide = $width;
                      }*/
                      
                      // copying the part into thumbnail
                      $thumbwidth = $width;
                      $thumbheight = $height;

                      $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
                      imagecopyresampled($thumb, $myImage, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
                 
                      header('Content-type: image/png');
       
                      $initfilename = uniqid() . ".png";
                $imagename= public_path("/storage/complaintimage/" . $initfilename);
               //////// $data['image'] = "complaintimage/".$initfilename;
               if($file->getMimeType()=='image/png') 
               {
                imagepng($thumb,$imagename);
               }
               else
               {
                imagejpeg($thumb,$imagename);

               }
            $attachment = new ComplaintAttachment;
            $attachment->complaint_id = $create->id;
            $attachment->media_name = "complaintimage/".$initfilename;
            $attachment->media_type = '0';
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
            $callerids = User::where('role', 1)->where('is_active', 1)->get();
            ////$ceoemail = User::where('role', 4)->first();
            if ($callerids) {
            foreach($callerids as $calleridss)
            {
                //$ceo = $ceoemail->email;
                $emails = [$calleridss->email];
                $mobiles = [$calleridss->mobile];
                $toids = [$calleridss->id];
                foreach ($toids as $key => $value) {
                    Notification::create(['userid' => $value, 'message' => 'A new inquiry has been registered. Please check the portal for <b> ' . $create->uuid . ' </b> details.']);
                }
                }
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
