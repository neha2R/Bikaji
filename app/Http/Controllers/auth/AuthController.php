<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Session;
use URL;
use Redirect;

class AuthController extends Controller
{
    public function login(){
        try {
            Session::put('url.intended',URL::previous());
           return view('admin.auth.login');
        } catch (\Throwable $th) {
           $this->customerr($th);
        }
    }
    public function handellogin(Request $request){
        try {
           $email=$request->email;
           $password=$request->password;
           $authcheck=Auth::attempt(['email' => $email, 'password' => $password,'is_active'=>1]);
            if ($authcheck) {
                $role=auth()->user()->role;
                switch ($role) {
                    case 0:
                        return redirect()->route('admindashboard');
                        break;
                    case 1:
                        // dd(Session::get('url.intended'));
                        if(Session::get('url.intended')=='http://care.bikaji.com/frontoffice/inquiry' &&  'http://care.bikaji.com/frontoffice/customercomplaintslist'){
                            return Redirect::to(Session::get('url.intended'));

                        }
                        return redirect()->route('frontofficereoports');
                        break;
                    case 2:
                        return redirect()->route('jdashboard');
                        break;
                    case 3:
                        return redirect()->route('sdashboard');
                        break;
                    case 4:
                        return redirect()->route('ceo');
                        break;
                    
                    default:
                       return redirect()->route('login');
                        break;
                }
            } else {
                return redirect()->route('login')->with(['message'=>'Invalid Credentials']);
            }
        } catch (\Throwable $th) {
           $this->customerr($th);
        }
    }

    public function logout(){
        try {
            Auth::logout();
            return redirect()->back();
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function resetpassword(){
        try {
            return view('admin.auth.forgot');
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function handelresetpassword(Request $request){

        try {
            $email=$request->email;
            $token=Str::random(60);
            $createtoken= User::where('email',$email)->update(['remember_token'=>$token]);
            Mail::to('virendra.singh.shekhawat@neologicx.com')->send(new ForgotPassword($email,$token));
            return redirect()->route('mailsuccess');
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
        
    }

    public function mailsuccess(){
        return view('mail.auth.mailsuccess');
    }

    public function recovery($email,$token){
        try {
          $check= User::where(['email'=>$email,'remember_token'=>$token])->exists();
          if ($check) {
             return view('admin.auth.reset',['token'=>$token,'email'=>$email]);
          } else {
             return redirect()->route('login');
          }
          
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function recoveryhandel(Request $request){
        try {
            $email=$request->email;
            $token=$request->token;
            $check= User::where(['email'=>$email,'remember_token'=>$token])->exists();
          if ($check) {
              $password=$request->password;
              $password=Hash::make($password);
              $updatepass= User::where(['email'=>$email])->update(['password'=>$password]);
              $check= User::where(['email'=>$email,'remember_token'=>$token])->update(['remember_token'=>'null1']);
              return redirect()->route('login')->with(['msg'=>'Password changed successfully please login']);
          } else {  
             return redirect()->back();
          }
          
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }


}
