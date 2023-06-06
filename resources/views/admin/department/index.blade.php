@extends('admin.layout.adminapp')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Create Department</h5>
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
                <form action="" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-round" placeholder="Enter Department Name" name="name">
                            @error('name')
                               <span style="color: red;padding:10px"> {{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success btn-round">Create Department</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Active/Deactivate</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->name ?? 'N/A'}}</td>
                                <td><label class="switch">
                                        <input type="checkbox" onchange="adminchangedepartmentstatus({{$item->id}},{{$item->is_active}})" {{$item->is_active ? 'checked':'' }}>
                                        <span class="slider round"></span>
                                    </label></td>
                                <td><a class="btn btn-warning btn-round" href="{{route('updatedeparment',['id'=>$item->id])}}" >Update</a></td>
                                <td><button class="btn btn-danger btn-round" onclick="admindepartmentdelete({{$item->id}})" >Delete</button></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
