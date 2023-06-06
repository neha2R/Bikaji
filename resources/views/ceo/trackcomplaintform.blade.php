@extends('ceo.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Track Complaint</h5>
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
                <form action="" method="get">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile Number</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-round" placeholder="Enter Mobile Number" name="mobileno" @if (request()->has('mobileno'))
                                value={{request()->get('mobileno')}}
                            @endif>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success btn-round">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@if (request()->has('refno'))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                @if (count($gettransitions))
                    <ul>
                        @foreach ($gettransitions as $item)
                        @if ($item->is_transfered)
                        <li>
                            <strong>Department : {{optional($item->department)->name ?? ''}}</strong>
                        </li>
                        <li>
                            <strong>Transferred from :</strong> {{optional($item->fromuserrelation)->name ?? ''}}
                        </li>
                        <li>
                            <strong>Transferred to :</strong> {{optional($item->touserrelation)->name ?? ''}}
                        </li>
                        <li>
                            <strong>Transfer Comment :</strong> {{$item->transfer_comment ?? ''}}
                        </li>
                        <hr>
                        @else
                        <li>
                            <strong>Department : {{optional($item->department)->name ?? ''}}</strong>
                        </li>
                        <li>
                            <strong>Transferred from :</strong> {{optional($item->fromuserrelation)->name ?? ''}}
                        </li>
                        @if (checkifresolved(optional($item->complaint)->id))
                        <li>
                            <strong>Resolved by :</strong> {{optional($item->touserrelation)->name ?? ''}}
                        </li>
                        <li>
                            <strong>Resolution :</strong> {{getresolution($item->complaintid)->resolution ?? ''}}
                        </li>
                        <li>
                            <strong>Resolution Date & Time :</strong> {{date('d-m-Y h:i A', strtotime(getresolution($item->complaintid)->created_at ?? ''))}}
                        </li>
                        @else
                        <li>
                            <strong>Transferred to :</strong> {{optional($item->touserrelation)->name ?? ''}}
                        </li>
                            <strong>Yet to be resolved</strong>
                        @endif
                        @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@if (request()->has('mobileno'))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <div style="overflow-x: scroll;">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>UUID</th>
                                <th>Customer Name</th>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Tracking Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getcomplaints as $key => $item)
                            <tr>
                                <th>{{$key + 1}}</th>
                                <th>{{$item->uuid ?? 'N/A'}}</th>
                                <th>{{$item->customername ?? 'N/A'}}</th>
                                <th>{{$item->title ?? 'N/A'}}</th>
                                <th>{{$item->details ?? 'N/A'}}</th>
                                <td><a href="?refno={{$item->uuid}}" class="btn btn-info">Track</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection