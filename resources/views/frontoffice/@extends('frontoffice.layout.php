@extends('frontoffice.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="row">
        <div class="col-md-12">
            <div class="card"  id="section1">
                <div class="card-header">
                    <h3>Inquiry Listing</h3>
                    
                    {{-- <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span> --}}
                    <div style="padding: 20px;border:1px solid black">
                        <h5>Inquiry Filter</h5>

                     



                        <form id="date-filter"  action="{{route('frontofficedashboard')}}">
                        <div class="row">
                        <div class="col-md-3" style="text-align: center;margin-top: 20px;">
        <div class="dropdown-primary dropdown open">
            <button class="btn btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @switch(request()->get('type'))
                @case('resolved')
                    Resolved Complaints
                    @break
                @case('crossedtl')
                    Crossed Timeline
                    @break
                @case('pending')
                    Pending Complaints
                    @break
                @default
                    All Complaints
            @endswitch
            </button>
            <input type="hidden" id="type" name="type" value="<?php echo request()->get('type');?>">

            <input type="hidden" id="cmptype" name="cmptype" value="<?php echo request()->get('type');?>">
            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn"
                data-dropdown-out="fadeOut" x-placement="top-start"
                style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'crossedtl'])}}">Complaints with Crossed
                    Timeline</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'pending'])}}">Pending Complaints</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'resolved'])}}">Resolved Complaints</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{route('frontofficedashboard')}}">All Complaints</a>
            </div>
        </div>
    </div>
    <input type="hidden" id="cmpsource" name="cmpsource" value="<?php echo request()->get('cmpsource');?>">

    <div class="col-md-3" style="text-align: center;margin-top: 20px;">
        <div class="dropdown-primary dropdown open">
            <button class="btn btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Complaint Source</button>
            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn"
                data-dropdown-out="fadeOut" x-placement="top-start"
                style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform; height:200px; overflow-y:scroll;">
                
            </div>
        </div>
    </div>
                                            </div>
                                            <div class="col-md-2" style="text-align: center;margin-top:20px;">
                                            </div>
                                            <h5>Complaint Filter By Date</h5>

                            <div class="row" style="margin-top:20px;">
                                <div class="col-md-5">
                                    <input id="dropper-default-from" class="form-control" type="text"
                                        placeholder="Select your from date" value="{{request()->fromdate}}" name="fromdate">
                                </div>
                                <div class="col-md-5">
                                    <input id="dropper-default-to" class="form-control" type="text"
                                        placeholder="Select your to date" value="{{request()->todate}}" name="todate">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                             
                              <div class="col-md-2" style="margin-top:15px;">
                              <input type="submit" class="btn btn-primary" name="export" value="Export to Excel">
                                </div>
                                <div class="col-md-2" style="margin-top:15px;">
                                <input type="button" class="btn btn-primary" onclick="resetForm();" name="export" value="Reset">

    </div>
                            </div>
                        </form>
                    </div>


                </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>UUID</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                {{-- <th>Days In System</th> --}}
                                <th>Details</th>
                                {{-- <th>Department</th> --}}
                                <th>Inquiry Source</th>
                                <th>Resolve Inquiry</th>
                                <th>Transfer Inquiry</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            
                            <tr>
                                <th>{{$key + 1}}</th>
                                <th>{{$item->inquiry->uuid ?? 'N/A'}}</th>
                                <th>{{$item->inquiry->customername ?? 'N/A'}}</th>
                                <th>{{$item->inquiry->contact ?? 'N/A'}}</th>
                                {{-- <th><label class="label badge-primary">{{$item->created_at->diffInDays(now()) ?? 'N/A'}}
                                Days</label><br><label class="label badge-warning">Created On
                                    :{{ datefomat($item->created_at)}}</label></th> --}}
                                    <th>{{$item->inquiry->details ?? 'N/A'}}</th>
                                {{-- <th>{{optional($item->departmentrelation)->name ?? 'N/A'}}</th> --}}
                                <th>{{optional(!empty($item->inquiry->inquirysourcerelation))->name ?? 'Customer Inquiry'}}</th>
                                <th>
                                    @if (inquirycheckifresolved($item->inquiryid))
                                     Resolved
                                    @else
                                    @if (inquirycheckiftransferred($item->inquiryid))
                                        Transferred
                                    @else
                                    <form action="{{route('resolveinquiryfront')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="{{$item->inquiryid}}">
                                            {{-- <input type="hidden" name="title" value="{{$item->title}}"> --}}
                                            <input type="hidden" name="name" value="{{!empty($item->inquiry->customername)}}">
                                            <input type="hidden" name="uuid" value="{{!empty($item->inquiry->uuid)}}">
                                            <div class="form-group">
                                                <label>Document</label>
                                                    <input type="file" id="document" name="document"  />
                                                </div>
                                            {{-- <label for="exampleFormControlTextarea1">Example textarea</label> --}}
                                            <textarea id="exampleFormControlTextarea1" rows="4" cols="25"
                                                name="resolution" minlength="50" required></textarea>
                                            <div style="padding: 5px">
                                                <button type="submit" class="btn btn-primary btn-round btn-sm">Mark as
                                                    resolve</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                   
                                    @endif

                                </th>
                                <th>
                                    @if (inquirycheckifresolved($item->inquiryid))
                                        Resolved
                                    @else
                                    @if (inquirycheckiftransferred($item->inquiryid))
                                        Transferred
                                    @else
                                    <select class="js-example-basic-single col-sm-12 transferinquiry form-control" id="{{$item->inquiryid}}" style="padding: 0;">
                                        <option>Transfer to</option>
                                        @foreach ($users as $user)
                                        @if ($user->id != auth()->user()->id)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @endif
                                    
                                    @endif
                                </th>
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
