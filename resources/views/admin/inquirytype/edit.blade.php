@extends('admin.layout.adminapp')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Inquiry Type</h5>
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
                        <label class="col-sm-2 col-form-label">Inquiry Type</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control form-control-round" placeholder="Enter Department Name" name="inquirytype" value="{{$data->name ?? 'N/A'}}">
                        </div>
                    </div>
                    <button class="btn btn-success btn-round" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection