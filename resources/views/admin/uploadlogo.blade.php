@extends('admin.layout.adminapp')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Upload Logo</h5>
                <hr>
                @if (session()->has('msg'))
                <div class="alert alert-success background-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>{{session()->get('msg')}}!</strong>
                </div>
                @endif
            </div>
            <div class="card-block">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Logo Image</label>
                        <div class="col-sm-7">
                            <input type="file" class="form-control form-control-round"  name="file">
                            <p class="text-info">
                                Dimensions of the logo image should be 100 X 62px
                            </p>
                            @error('file')
                               <span style="color: red;padding:10px"> {{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success btn-round">Upload</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection