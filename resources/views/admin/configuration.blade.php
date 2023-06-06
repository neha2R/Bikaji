@extends('admin.layout.adminapp')
@section('content')
<div class="card">
    <div class="card-body">
        @foreach ($data as $item)
        <h3>{{$item->name}}</h3>


       
            @foreach ($item->actiontrigger as $one)
            <div class="card-header">
                <h4>{{$one->rolerelation->name}} {{$one->rolerelation->descripiton}}</h4>
            </div>
            <div class="card-body">
            <form action="{{route('configureactionshandel')}}" method="post">
                @csrf
                <div class="row">
                    <input type="hidden" name="actionid" value="{{$item->id}}">
                    <input type="hidden" name="role" value="{{$one->role}}">
                    <div  class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"  name="email" {{$one->is_email ? 'checked' : ''}} >
                                <label class="form-check-label" for="exampleCheck1">Email</label>
                            </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="sms" {{$one->is_sms ? 'checked' : ''}} >
                            <label class="form-check-label" for="exampleCheck1">SMS</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        {{-- <div class="form-check">
                        <input type="checkbox" class="form-check-input"  name="whatsapp" {{$one->is_whatsapp ? 'checked' : ''}} >
                            <label class="form-check-label" for="exampleCheck1">WhatsApp</label>
                        </div> --}}
                    </div>
                    <div  class="col-md-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                </form>
            </div>
            @endforeach
            
        <hr>
        @endforeach
        </form>
    </div>
</div>

@endsection
