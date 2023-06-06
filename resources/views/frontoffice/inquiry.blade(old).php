@extends('frontoffice.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Inquiry Table</h5>
                <div style="padding: 20px;border:1px solid black">
                    <h5>Inquiry Filter</h5>
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <input id="dropper-default-from" class="form-control" type="text"
                                    placeholder="Select your from date" name="fromdate">
                            </div>
                            <div class="col-md-5">
                                <input id="dropper-default-to" class="form-control" type="text"
                                    placeholder="Select your to date" name="todate">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="submit">Filter</button>
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
