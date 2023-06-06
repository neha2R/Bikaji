<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplaintType;

class ComplaintTypeController extends Controller
{
    public function index(){
        try {
            $data=ComplaintType::orderBy('id','desc')->get();
            // dd($data);
            return view('admin.complainttype.index',compact('data'));
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }
    public function create(Request $request){
        try {
            
            $name=$request->name;
            $data=ComplaintType::create(['name'=>$name]);
            return redirect()->back()->with(['Msg'=>'Complaint Type Created Successfully!']);            
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function edit($id){
        try {
            $data=ComplaintType::findorFail($id);
            return view('admin.complainttype.edit',compact('data'));
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }
    public function update(Request $request,$id){
        try {
            $name=$request->name;
            $data=ComplaintType::findorFail($id)->update(['name'=>$name]);
            return redirect()->back()->with(['Msg'=>'Complaint Type Updated Successfully!']);
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function delete($id){
        try {
            ComplaintType::findorFail($id)->delete();
            return response()->json(['status'=>200,'message'=>'deleted successfully']);
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }

    public function changestatus(Request $request){
        try {
            $status = 1- $request->status;
            ComplaintType::findorFail($request->id)->update(['is_active'=>$status]);
            return response()->json(['status'=>200,'message'=>'Change Status Successfully']);
        } catch (\Throwable $th) {
            return  $this->customerr($th);
        }
    }
}
