@extends('admin.layout.adminapp')
@section('content')
<script src="{{URL::asset('files\assets\js\admincustom.js')}}"></script>
<script src="{{URL::asset('files\assets\js\tabpanel-custom.js')}}"></script>
@if (session()->has('status'))
       <input type="hidden" id="inquirytab" value="{{session()->get('status')}}">
        @endif
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12">
        <div class="card">
            <div class="card-block tab-icon">
                <div class="col-lg-12 col-xl-12 col-md-12">
                    <div class="sub-title">Employees Managment</div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" id="homelink"><i class="icofont icofont-home"></i>All Employee</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" id="profilelink"><i class="icofont icofont-ui-user "></i>Create Employee</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content card-block">
                        <div class="tab-pane active" id="home7" role="tabpanel">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>MOB</th>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$item->name ?? 'N/A'}}</td>
                                             <td>{{optional($item->roleuser)->name ?? 'N/A'}}</td>
                                           <!-- <td>{{$item->details->employee_id ?? 'N/A'}}</td> !-->
                                            <td>{{$item->mobile ?? 'N/A'}}</td>
                                            @php $myArray = explode(',', $item->department);

                                            $departmentname = App\Models\Department::whereIn('id',$myArray)->pluck('name')->toArray();
                                            
                                            $departmentname = implode(',',$departmentname);
                                            
                                            @endphp
                                        

                                            <td>{{$departmentname ?? 'N/A'}}</td>

                                            <td>{{optional($item->roleuser)->descripiton ?? 'N/A'}}</td>
                                            <td>{{$item->email ?? 'N/A'}}</td>
                                            <td>
                                                <a href="{{route('editemployee', $item->id)}}" class="btn btn-primary">Update</a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile7" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Create Employee</h5>
                                </div>
                                <div class="card-block">
                                    <form id="main" method="post" action="{{route('handelemployee')}}" novalidate="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Employee Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Employee Name">
                                                {!! $errors->first('name', '<p style="color: red" class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Employee ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="password" name="empid" placeholder="Employee ID">
                                                {!! $errors->first('empid', '<p style="color: red" class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Profile</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="profile" name="profile">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Employee Mobile</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  name="mobile" maxlength="10" placeholder="Employee Mob">
                                                {!! $errors->first('mobile', '<p style="color: red" class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Employee Department</label>
                                            <div class="col-sm-10">
                                                <select name="department" class="form-control">
                                                    @foreach($departments as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->name ?? 'N/A'}}</option>
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
                                                    <option value="{{$value->id}}">{{$value->name ?? 'N/A'}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                                {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Other</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="email" name="other" placeholder="Others">
                                                {!! $errors->first('other', '<p style="color: red" class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
