<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InquiryType;
use Illuminate\Support\Str;

class InquiryTypeController extends Controller
{
    public function index(){
        try {
            $data=InquiryType::orderBy('id','desc')->get();
           return View('admin.inquirytype.index',compact('data'));
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function  changestatus(Request $request){
        try {
            $status = 1- $request->status;
            InquiryType::findorFail($request->id)->update(['is_active'=>$status]);
            return response()->json(['status'=>200,'message'=>'Change Status Successfully']);
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function create(Request $request){
        // try {
            $request['name']=Str::ucfirst($request->name);
            $validatedData = $request->validate([
                'name' => 'required|unique:departments|max:255',
            ]);
          $data= InquiryType::create(['name'=>$request->name]);
            if ($data->id) {
               return redirect()->back()->with(['Msg'=>'Inquiry Type Created Successfully']);
            } else {
                return redirect()->back()->with(['Msg'=>'Something Went Wrong']);
            }
        // } catch (\Throwable $th) {
        //     return  $this->customerr($th);
        // }
    }

    public function edit($id){
        try {
            $data=InquiryType::findorFail($id);
           return view('admin.inquirytype.edit',compact('data'));
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function update(Request $request,$id){
        try {
            $name=$request->inquirytype;
            $data=InquiryType::findorFail($id)->update(['name'=>$name]);
            return redirect()->back()->with(['Msg'=>'Inquiry Type Updated Successfully']);
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function delete($id){
        try {
            InquiryType::findorFail($id)->delete();
            return response()->json(['status'=>200,'message'=>'Inquiry Type Deleted Successfully']);
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

}
