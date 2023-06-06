@extends('admin.layout.adminapp')
@section('content')
<style>
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-block">
                <h4 class="sub-title">Configurations</h4>
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($configuration as $key => $item)
                            {{-- {{dd($item)}} --}}

                            <tr>
                            <td>{{$key + 1}}</td>
                                <td><a href="#leveltable"><strong>{{levelname($item->from)}}</strong></a></td>
                                <td><a href="#leveltable"><strong>{{levelname($item->to)}}</strong></a></td>
                                <td>
                                <form method="post" action="{{route('adminconfigurationupdate')}}">
                                        @csrf
                                    <input type="hidden"  value="{{$item->from}}" name="from">
                                    <input type="hidden"  value="{{$item->to}}" name="to">
                                        <div class="form-group row">
                                            <div class="col-sm-4"><input type="number" required min="1" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                 value="{{$item->days ?? 'N/A'}}" class="form-control" name="days"></div>
                                            <div class="col-sm-3"><button class="btn btn-primary">update</button></div>
                                        </div> 
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"><strong>Total Time to Resolve Complaint in Days</strong></td>
                                <td>{{$configuration->sum('days')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Levels Refs</h5>
                {{-- <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span> --}}

            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="leveltable" class="table table-striped table-bordered nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            {{-- {{dd($item)}} --}}
                            <tr>
                            <td>{{$key + 1}}</td>
                                <td>{{$item->name ?? 'N/A'}}</td>
                                <td>{{$item->descripiton ?? 'N/A'}}</td>
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