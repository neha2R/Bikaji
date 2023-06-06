@extends('frontoffice.layout.app')
@section('content')
@if (session()->has('status'))
       <input type="hidden" id="inquirytab" value="{{session()->get('status')}}">
        @endif
        <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#demo">Simple collapsible</button>

<div class="row collapse" id="demo">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
            </div>

            <div class="card-block">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <div class="col-lg-12 col-xl-12 col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" id="homelink"><i class="icofont icofont-home"></i>Create Complaint</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" id="profilelink"><i class="icofont icofont-ui-user "></i>Create Inquiry</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content card-block">

                        <div class="tab-pane active" id="home7" role="tabpanel">
                            <form method="POST" id="createcomplaint" action="{{route('createcomplaint')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" name="customername" placeholder="Customer Name" minlength="3" required maxlength="50" >
                                        {!! $errors->first('customername', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Mobile Number</label>
                                    <div class="col-sm-10">
                                        <input type="number" required class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">
                                        {!! $errors->first('mobile', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                                        {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Complaint Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" placeholder="Complaint Title" required maxlength="100" >
                                        {!! $errors->first('title', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Details</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" cols="5" class="form-control" name="details" placeholder="Details" maxlength="500"></textarea>
                                        {!! $errors->first('details', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Upload File</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Department</label>
                                    <div class="col-sm-10">
                                        <select name="ct" class="form-control">
                                            @foreach ($deparments as $item)
                                            <option value="{{$item->id}}">{{$item->name ?? 'N/A'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Source</label>
                                    <div class="col-sm-10">
                                        <select name="cs" class="form-control">
                                            @foreach ($complaintsource as $item)
                                            <option value="{{$item->id}}">{{ucwords($item->name ?? 'N/A')}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer Type</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" name="customer_type" placeholder="Customer Type" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="customer_address" placeholder="Customer Address" maxlength="250">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer City</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" name="customer_city" placeholder="Customer City" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer State</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" name="customer_state" placeholder="Customer State"  maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Invoice No</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="customer_invoice_no" placeholder="Invoice No" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Purchase Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" id="purchase" class="form-control" name="purchase_date" placeholder="Purchase Date">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Delivary Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" id="delivary" class="form-control" name="delivary_date" placeholder="Delivary Date">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="product_name" placeholder="Product Name" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Category</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="product_category" placeholder="Product Category" maxlength="50">
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product SKU</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="sku" placeholder="Product SKU" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Batch No</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="batch_number" placeholder="Product Batch No" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Manufacturing Date </label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="mfg" placeholder="Manufacturing Date">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Production Facility </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="production_facility" placeholder="Production Facility" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Risk Category </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="risk_category" placeholder="Risk Category" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Type </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="complaint_type" placeholder="Complaint Type" maxlength="50">
                                    </div>
                                </div>


                                <button class="btn btn-primary">Create Complaint</button>

                            </form>
                        </div>
                        <div class="tab-pane" id="profile7" role="tabpanel">
                            <form method="POST" id="createinquiry" action="{{route('createinquiry')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="1">
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="customername" placeholder="Customer Name" oninvalid="setCustomValidity('Please enter on alphabets only. ')" maxlength="50" required>
                                        {!! $errors->first('customername', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Contact Number</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inqmobile" name="contact" required placeholder="Mobile Number">
                                        {!! $errors->first('contact', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" placeholder="Email" required maxlength="50">
                                        {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 col-form-label">Details</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" cols="5" class="form-control" name="details" placeholder="Details" maxlength="250" required></textarea>
                                        {!! $errors->first('details', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">State</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="state" placeholder="State" maxlength="50">
                                        {!! $errors->first('state', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pincode</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pincode" placeholder="Pincode" maxlength="6">
                                        {!! $errors->first('pincode', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">City</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="city" placeholder="City" maxlength="50">
                                        {!! $errors->first('city', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Inquiry Source</label>
                                    <div class="col-sm-10">
                                        <select name="is" class="form-control">
                                            @foreach ($inquirysource as $item)
                                            <option value="{{$item->id}}">{{$item->name ?? 'N/A'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary">Create Inquiry</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Complaint Listing</h3>
                {{-- <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span> --}}
                <div style="padding: 20px;border:1px solid black">
                    <h5>Complaint Filter</h5>
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <input id="dropper-default-from" class="form-control" type="text" placeholder="Select your from date" name="fromdate">
                            </div>
                            <div class="col-md-5">
                                <input id="dropper-default-to" class="form-control" type="text" placeholder="Select your to date" name="todate">
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
                    <table id="simpletable1" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                {{-- <th>UUID</th> --}}
                                <th>Customer Name</th> 
                                <th>Mobile</th>
                                <th>Days In System</th>
                                <th>Complaint Source</th> 
                                <!-- <th>Details</th> -->
                                <!-- <th>Attachment</th> -->
                                <!-- <th>Department</th> -->
                                <th>Resolve issue</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $key => $item)
                            {{-- {{dd($item->departmentrelation)}} --}}

                            <tr>

                                <td>{{$key + 1}}</td>
                                {{-- <td>{{$item->uuid ?? 'N/A'}}</td> --}}
                                <td>{{$item->customername ?? 'N/A'}}</td>
                                <th>{{$item->mobile ?? 'N/A'}}</th>
                                <th><label class="label badge-primary">{{$item->created_at->diffInDays(now()) ?? 'N/A'}} Days</label><br/><label class="label badge-warning" style="line-height: 20px;">Created On :{{ datefomat($item->created_at)}}</label></th>
                                <td style="text-align: center">{{App\Models\ComplaintSource::find($item->complaintsource)->name ?? '-'}}</td>
                                <!-- <th scope="row" class="nowrap">{{$item->details ?? 'N/A'}}</th> -->

                                <!-- <td>
                                    @if ($item->image)
                                    @php
                                    $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

                                    $explodeImage = explode('.', "$item->image");
                                    $extension = end($explodeImage);
                                     @endphp
                                    @if(in_array($extension, $imageExtensions))
                                    <a href="{{\Storage::disk('public')->url($item->image)}}" target="_blank">View In Full</a><br><img src="{{\Storage::disk('public')->url($item->image)}}" alt="" srcset="" height="150px" width="150px">
                                    @else
                                    <a href="{{\Storage::disk('public')->url($item->image)}}" target="_blank">View In Full</a><br><img src="../dummyfile.png" alt="" srcset="" height="150px" width="150px">
                                    @endif


                                    @else
                                        No Image
                                    @endif
                                </td> -->

                                <!-- <td>{{optional($item->departmentrelation)->name ?? 'N/A'}}</td> -->

                                <!-- <td>{{optional($item->complaintsourcerelation)->name ?? 'Customer Complaint'}}</td> -->

                                <th>
                                @if (checkifresolved($item->id))

                                Resolved
</th><th>
                                @else

                                    {{-- {{dd($item->complaintresoultionrelation)}} --}}


                                    <form action="{{route('resolvecomplaintfront')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="title" value="{{$item->title}}">
                                        <input type="hidden" name="name" value="{{$item->customername}}">
                                        <input type="hidden" name="uuid" value="{{$item->uuid}}">
                                        <div class="form-group">
                                        <label>Document</label>
                                            <input type="file" id="document" name="document"  />
                                        </div>
                                        <div class="form-group">
                                            <textarea id="exampleFormControlTextarea1" rows="4" cols="25" name="resolution" minlength="50" ></textarea>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-round btn-sm">Mark as resolve</button>
                                        </div>
                                    </form>
</th>

                                
                                <td>
                                    <a href="editcomplaint/{{$item->id}}" class="btn btn-primary waves-effect ">Edit</a>
                                    <button type="button" class="btn btn-primary waves-effect complaintresolvebtn" data-toggle="modal"
                                    data-target="#view-data{{$key + 1}}">
                                        View
                                    </button>
                                </td>
                                @endif
                            </tr>
                            <div class="modal fade" id="view-data{{$key + 1}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Complaint</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">UUID </label>
                                    <div class="col-sm-8">
                                        <span><b>{{$item->uuid ?? 'N/A'}}</b></span>

                                    </div>
                                </div>
                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Customer Name</label>
                                    <div class="col-sm-8">
                                        <span><b>{{$item->customername ?? 'N/A'}}</b></span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Mobile Number</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->mobile ?? 'N/A'}}</b></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->email ?? 'N/A'}}</b></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Complaint Title</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->title ?? 'N/A'}}</b></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Details</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->details ?? 'N/A'}}</b></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Complaint Department</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->complainttype ?? 'N/A'}}</b></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Complaint Source</label>
                                    <div class="col-sm-8">
                                    <span><b>{{App\Models\ComplaintSource::find($item->complaintsource)->name ?? 'N/A'}}</b></span>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Customer Type</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->customer_type ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Customer Address</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->customer_address ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Customer City</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->customer_city ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Customer State</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->customer_state ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Invoice No</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->customer_invoice_no ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Purchase Date</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->purchase_date ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Delivary Date</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->delivary_date ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Product Name</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->product_name ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Product Category</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->product_category ?? 'N/A'}}</b></span>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Product SKU</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->sku ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Product Batch No</label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->batch_number ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Manufacturing Date </label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->mfg ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Production Facility </label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->production_facility ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Risk Category </label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->risk_category ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Complaint Type </label>
                                    <div class="col-sm-8">
                                    <span><b>{{$item->complaint_type ?? 'N/A'}}</b></span>
                                    </div>
                                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light submitinquiryresolution">Ok
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#simpletable1').DataTable({
            // "lengthMenu": [[3,], [10, 20, 30, "All"]],
            "searching": true,


        });

        $('.text').on('keypress', function(e) {
          var regex = new RegExp("^[a-zA-Z ]*$");
          var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
          if (regex.test(str)) {
             return true;
          }
          e.preventDefault();
          return false;
         });

        $("#mobile").change(function (e) {
            var mobileNum = $('#mobile').val();
var validateMobNum= /^\d*(?:\.\d{1,2})?$/;
if (validateMobNum.test(mobileNum ) && mobileNum.length == 10) {
    return true;
}
else {
    $("#mobile").focus();
            return false;
}
      });

      $('#createcomplaint').on('submit', function() {
        var mobileNum = $('#mobile').val();
var validateMobNum= /^\d*(?:\.\d{1,2})?$/;
if (validateMobNum.test(mobileNum ) && mobileNum.length == 10) {
}
 else {
           alert("Please Enter only 10 digit mobile no")
        $("#mobile").focus();
            return false;
       }

            var from = new Date($("#purchase").val());
        var to = new Date($("#delivary").val());

        if(from > to){
        alert("Invalid Date Range of Purchase and Delivary");
        $("#delivary").focus();
            return false;
        }

        });



    $('#createinquiry').on('submit', function() {
        var mobileNum = $('#inqmobile').val();
var validateMobNum= /^\d*(?:\.\d{1,2})?$/;
if (validateMobNum.test(mobileNum ) && mobileNum.length == 10) {
}
 else {
           alert("Please Enter only 10 digit mobile no")
        $("#mobile").focus();
            return false;
       }


        });

    });


</script>
@endsection
