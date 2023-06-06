<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Department;
use App\Models\Levels;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    public function index(){
        try {
            $data=User::with('details')->orderBy('id','DESC')->get();
            $departments=Department::all();
            $levels=Levels::all();
            return view('admin.employee',compact('data','departments','levels'));
        } catch (\Throwable $th) {
            return   $this->customerr($th);
        }
    }

    public function store(Request $request){
        // dd($request);
        try {
            $customMessages = [
                'name.required' => 'Name is required',
                'empid.required' => 'Employee ID is required',
                'mobile.required' => 'Mobile number is required',
                'email.required' => 'Email is required',
                'other.required' => 'Other is required',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'empid' => 'sometimes|required|unique:user_details,employee_id',
                'mobile' => 'sometimes|required',
                'email' => 'sometimes|required|unique:users',
                'other' => 'sometimes|required',
            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator)->with('status', 1);
            }
            if ($request->hasFile('profile')) {
                $foldername = 'profileimage';
                $profile = $request->file('profile')->store($foldername, 'public');
            } else{
                $profile = '';
            }
            $password = Hash::make($request->mobile);
            $createuser=User::create(['name'=>$request->name,'email'=>$request->email,'mobile'=>$request->mobile,'role'=>$request->level, 'department' => $request->department, 'profileimage' => $profile, 'password' => $password])->id;
            $createdetails=UserDetails::create(['user_id'=>$createuser,'dep_id'=>$request->department,'employee_id'=>$request->empid,'other'=>$request->other]);
            return redirect()->back();
        } catch (\Throwable $th) {
            $this->customerr($th);
        }
    }

    public function edit($id){
       try {
        $data = User::where('id', $id)->with('details')->first();
        $departments=Department::all();
        $levels=Levels::all();
        return view('admin.editemployee',compact('data','departments','levels'));
       } catch (\Throwable $th) {
            $this->customerr($th);
       }
    }

    public function update(Request $request, $id){
        try {
            $detailid = UserDetails::where('user_id', $id)->first()->id;
            $customMessages = [
                'name.required' => 'Name is required',
                'empid.required' => 'Employee ID is required',
                'mobile.required' => 'Mobile number is required',
                'email.required' => 'Email is required',
                'other.required' => 'Other is required',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'empid' => 'sometimes|required|unique:user_details,employee_id,'.$detailid,
                'mobile' => 'sometimes|required',
                'email' => 'sometimes|required|unique:users,id,'.$id,
                'other' => 'sometimes|required',
            ], $customMessages);
            if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                return redirect()->back()->withErrors($validator)->with('status', 1);
            }
            $password = Hash::make($request->mobile);
            if ($request->hasFile('profile')) {
                $foldername = 'profileimage';
                $profile = $request->file('profile')->store($foldername, 'public');
                User::where('id', $id)->update(['name'=>$request->name,'email'=>$request->email,'mobile'=>$request->mobile,'role'=>$request->level, 'department' => $request->department, 'profileimage' => $profile, 'password' => $password]);
            } else{
                User::where('id', $id)->update(['name'=>$request->name,'email'=>$request->email,'mobile'=>$request->mobile,'role'=>$request->level, 'department' => $request->department, 'password' => $password]);
            }
            UserDetails::where('user_id', $id)->update(['dep_id'=>$request->department,'employee_id'=>$request->empid,'other'=>$request->other]);
            return redirect('/admin/employee');
        } catch (\Throwable $th) {
            // dd($th);
            $this->customerr($th);
        }
    }
}
