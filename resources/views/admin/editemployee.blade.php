@extends('admin.layout.adminapp')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Employee Details</h5>
                <hr>
                @if (session()->has('Msg'))
                <div class="alert alert-success background-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>{{session()->get('Msg')}}!</strong>
                </div>
                @endif
            </div>
            <div class="card-block">
                <form id="main" method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Employee Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" value="{{$data->name ?? ''}}">
                            {!! $errors->first('name', '<p style="color: red" class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Employee ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="empid" value="{{optional($data->details)->employee_id ?? ''}}">
                            {!! $errors->first('empid', '<p style="color: red" class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Profile</label>
                        <div class="col-sm-10">
                            @if ($data->profileimage)
                                <img src="{{\Storage::disk('public')->url($data->profileimage)}}" alt="user-profile" style="max-width: 150px; max-height: 200px;">
                            @endif
                            <input type="file" class="form-control" id="profile" name="profile">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Employee Mobile</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  name="mobile" maxlength="10" value="{{$data->mobile ?? ''}}">
                            {!! $errors->first('mobile', '<p style="color: red" class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Employee Department</label>
                        <div class="col-sm-10">
                            <select name="department" class="form-control">
                                @foreach($departments as $key => $value)
                                <option value="{{$value->id}}" @if ($data->department == $value->id) selected @endif>{{$value->name ?? 'N/A'}}</option>
                                @endforeach
                            </select>
                            <span class="messages"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Employee Level</label>
                        <div class="col-sm-10">
                            <select name="level" class="form-control">
                                @foreach($levels as $key => $value)
                                <option value="{{$value->id}}" @if ($data->role == $value->id) selected @endif>{{$value->name ?? 'N/A'}}</option>
                                @endforeach
                            </select>
                            <span class="messages"></span>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="{{$data->email ?? ''}}">
                            {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Other</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="other" value="{{optional($data->details)->other ?? ''}}">
                            {!! $errors->first('other', '<p style="color: red" class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection