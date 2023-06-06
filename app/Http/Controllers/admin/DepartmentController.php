<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Str;
class DepartmentController extends Controller
{
    public function index(){
        try {
            $data=Department::orderBy('id','desc')->get();
            return view('admin.department.index',compact('data'));
        } catch (\Throwable $th) {
            return $this->customerr($th);
        }
    }

    public function create(Request $request){
        $request['department']=Str::ucfirst($request->department);
        $validatedData = $request->validate([
            'name' => 'required|unique:departments|max:255',
        ]);
      $data= Department::create(['name'=>$request->name]);
        if ($data->id) {
           return redirect()->back()->with(['Msg'=>'Department Created Successfully']);
        } else {
            return redirect()->back()->with(['Msg'=>'Something Went Wrong']);
        }
    }

    public function departmentchangestatus(Request $request){
        try {  
            // dd($request);
            $status= 1 - $request->status;
            $update=Department::findorFail($request->id)->update(['is_active'=>$status]);
            if ($update) {
                return response()->json(['status'=>200,'message'=>'Department Updated Successfully']);
            } else {
                return response()->json(['status'=>201,'message'=>'Something Went Wrong']);
            }

        } catch (\Throwable $th) {
            return $this->customerr($th);
        }
    }

    public function edit($id){
        try {
            $data=Department::findorFail($id);
            return view('admin.department.edit',compact('data'));
        } catch (\Throwable $th) {
            return $this->customerr($th);
        }
    }
    public function update(Request $request,$id){
        // try {
            $validatedData = $request->validate([
                'department' => 'required|max:255|unique:departments,name,'.$id,
            ]);
            $data=Department::findorFail($id)->update(['name'=>$request->department]);
            return redirect()->back()->with(['Msg'=>'Department Update Successfully']);
        // } catch (\Throwable $th) {
        //     return $this->customerr($th);
        // }
    }

    public function delete($id){
        try {
            $data=Department::findorFail($id)->delete();
            return response()->json(['status'=>200,'message'=>'Department Deleted Successfully']);
        } catch (\Throwable $th) {
            return $this->customerr($th);
        }
    }
}
