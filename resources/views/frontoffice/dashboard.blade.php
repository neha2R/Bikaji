@extends('frontoffice.layout.app')
@section('content')
    @if (session()->has('status'))
        <input type="hidden" id="inquirytab" value="{{ session()->get('status') }}">
    @endif
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <div class="text-right" style="margin-bottom:10px;"><button  type="button" class="btn btn-primary " data-bs-toggle="collapse" data-bs-target="#demo">Register a complaint/inquiry</button></div>

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
                                <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" id="homelink"><i
                                        class="icofont icofont-home"></i>Create Complaint</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" id="profilelink"><i
                                        class="icofont icofont-ui-user "></i>Create Inquiry</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content card-block">

                            <div class="tab-pane active" id="home7" role="tabpanel">
                                <form method="POST" id="createcomplaint" action="{{ route('createcomplaint') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Customer Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control text" name="customername"
                                                placeholder="Customer Name" minlength="3" required maxlength="50">
                                            {!! $errors->first('customername', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Mobile Number</label>
                                        <div class="col-sm-10">
                                            <input type="number" required class="form-control" id="mobile"
                                                name="mobile" placeholder="Mobile Number">
                                            {!! $errors->first('mobile', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                      <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Complaint Source</label>
                                        <div class="col-sm-10">
                                            <select name="cs" class="form-control">
                                                @foreach ($complaintsource as $item)
                                                    <option value="{{ $item->id }}">{{ ucwords($item->name ?? 'N/A') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Email/Social Handle

</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter Email" >
                                            {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Complaint Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Complaint Title" required maxlength="100">
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
                                    <input type="file" id="files_1" style="display: block;" name="media_name[]" accept="image/*" multiple />

                                        </div>
                                    </div>
                                       <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Upload Videos</label>
                                        <div class="col-sm-10">
                                            
                                        <input type="file" id="videos_1" name="media_video[]" accept="video/*" multiple />

                                                                    <!---   <input type="file" class="form-control" name="file"> ---->
                                        </div>
                                       
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Complaint Department</label>
                                        <div class="col-sm-10">
                                            <select name="ct" class="form-control">
                                                @foreach ($deparments as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  


                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Customer Type</label>
                                        <div class="col-sm-10">
                                            <select name="customer_type" class="form-control">
                                                <option disabled selected value="">Choose customer type</option>
                                                <option value="Retail Customer">Retail Customer</option>
                                                <option value="Retail Counter">Retail Counter</option>
                                                <option value="Wholesaler">Wholesaler</option>
                                                <option value="Distributor">Distributor</option>
                                                <option value="C & F">C & F</option>
                                            </select>
                                            {{-- <input type="text" class="form-control text" name="customer_type"
                                                placeholder="Customer Type" maxlength="100"> --}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Customer Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="customer_address"
                                                placeholder="Customer Address" maxlength="250">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Customer State</label>
                                        <div class="col-sm-10">
                                            {{-- <input type="text" class="form-control text" name="customer_state"
                                                placeholder="Customer State" maxlength="50"> --}}
                                            <select name="customer_state" onchange="city_name()" class="js-example-basic-single col-sm-12 select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true" id="state">
                                                <option selected disabled value="">Choose state </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Customer City</label>
                                        <div class="col-sm-10">
                                            {{-- <input type="text" class="form-control text" name="customer_city"
                                                placeholder="Customer City" maxlength="100"> --}}
                                                <select  name="customer_city" onchange="city_name()" class="js-example-basic-single col-sm-12 select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true" id="city">
                                                <option selected disabled value="">Choose City </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Invoice No</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="customer_invoice_no"
                                                placeholder="Invoice No" maxlength="10">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Purchase Date</label>
                                        <div class="col-sm-10">
                                            <input type="date" id="purchase" class="form-control"
                                                name="purchase_date" placeholder="Purchase Date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Expiry Date</label>
                                        <div class="col-sm-10">
                                            <input type="date" id="delivary" class="form-control"
                                                name="delivary_date" placeholder="Delivary Date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Product Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="product_name"
                                                placeholder="Product Name" maxlength="100">
                                        </div>
                                    </div>

                                    <!---<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Product Category</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="product_category"
                                                placeholder="Product Category" maxlength="50">
                                        </div>
                                    </div>--->

                                 <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Category</label>
                                    <div class="col-sm-10">
                                        <select name="pc" class="form-control">
                                            @foreach ($category as $item)
                                            <option value="{{$item->id}}">{{ucwords($item->name ?? 'N/A')}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Product SKU</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="sku"
                                                placeholder="Product SKU" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Product Batch No</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="batch_number"
                                                placeholder="Product Batch No" maxlength="50">
                                        </div>
                                    </div>
                               <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                    OR
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Upload Product Batch File</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="batchfile">
                                    </div>
                                </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Manufacturing Date </label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="mfg"
                                                placeholder="Manufacturing Date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Production Facility </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="production_facility"
                                                placeholder="Production Facility" maxlength="50">
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Risk Category </label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                        <div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Very High" />
  <h1 style="background-color:#ff0000;font-size:17px;width: 50%;">Very High</h1>
</div>

<div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="High" />
  <h1 style="background-color:#ffc100;font-size:17px;width: 25%;">High</h1>
</div>

<div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="Medium"  />
  <h1 style="background-color:#ffff00;font-size:17px;width: 44%;">Medium</h1>
</div>

<div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="Low"  />
  <h1 style="background-color:#00cd00;font-size:17px;width: 22%;">Low</h1>
</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Purchase Method</label>
                                        <div class="col-sm-10">
                                            <select name="complaint_type" class="form-control">
                                                <option disabled selected value="">Choose complaint type</option>
                                                <option value="Online Purchase">Online Purchase</option>
                                                <option value="Offline Purchase">Offline Purchase</option>
                                            </select>
                                        </div>
                                    </div>


                                    <button class="btn btn-primary">Create Complaint</button>

                                </form>
                            </div>
                            <div class="tab-pane" id="profile7" role="tabpanel">
                                <form method="POST" id="createinquiry" action="{{ route('createinquiry') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="1">
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Customer Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="customername"
                                                placeholder="Customer Name"
                                                oninvalid="setCustomValidity('Please enter on alphabets only. ')"
                                                maxlength="50" required>
                                            {!! $errors->first('customername', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Contact Number</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="inqmobile" name="contact"
                                                required placeholder="Mobile Number">
                                            {!! $errors->first('contact', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Email" required maxlength="50">
                                            {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 col-form-label">Details</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" cols="5" class="form-control" name="details" placeholder="Details" maxlength="250"
                                                required></textarea>
                                            {!! $errors->first('details', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">State</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="state"
                                                placeholder="State" maxlength="50">
                                            {!! $errors->first('state', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Pincode</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="pincode"
                                                placeholder="Pincode" maxlength="6">
                                            {!! $errors->first('pincode', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">City</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="city" placeholder="City"
                                                maxlength="50">
                                            {!! $errors->first('city', '<p style="color: red" class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Inquiry Source</label>
                                        <div class="col-sm-10">
                                            <select name="is" class="form-control">
                                                @foreach ($inquirysource as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name ?? 'N/A' }}
                                                    </option>
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
    <div class="row" >
        <div class="col-md-12">
            <div class="card" id="section1">
                <div class="card-header">
                    <h3>Complaint Listing </h3>
                    <h5>(Kindly Reset the Form first after each Filter option before moving to another filter)</h5>
                    {{-- <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span> --}}
                    <div  style="padding: 20px;border:1px solid black">
                        <h5>Complaint Filter</h5>
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
                @if (count($complaintsource))
                @foreach ($complaintsource as $item)
                <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['cmpsource' => $item->id])}}">{{$item->name}}</a>
                @endforeach
                @endif
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
                        </form>
                    </div>


                </div>
                
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable1" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    {{-- <th>UUID</th> --}}
                                    <th>Complainant</th>
                                    <th>Mobile</th>
                                    <th>Pending Since</th>
                                    <th>Source</th>
                                    <th>Registered by</th>
                                    <th>Assignee</th>

                                    <!-- <th>Details</th> -->
                                    <!-- <th>Attachment</th> -->
                                    <!-- <th>Department</th> -->
                                    <th>Resolution</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($complaints as $key => $item)
                                    {{-- {{dd($item->departmentrelation)}} --}}

                                    <tr>

                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{ $item->uuid ?? 'N/A' }}</td> --}}
                                        <td>{{ $item->customername ?? 'N/A' }}</td>
                                        <th>{{ $item->mobile ?? 'N/A' }}</th>
                                        <th><label
                                                class="label badge-primary">{{ $item->created_at->diffInDays(now()) ?? 'N/A' }}
                                                Days</label><br /><label class="label badge-warning"
                                                style="line-height: 20px;">Created On
                                                :{{ datefomat($item->created_at) }}</label></th>
                                        <td>{{ App\Models\ComplaintSource::find($item->complaintsource)->name ?? 'N/A' }}</td>
                                        <td>{{ App\User::find($item->createdby)->email ?? 'N/A' }}</td>

                                       <td>
                                            
                                        @php $Transfer=App\Models\Transition::where('complaintid',$item->id)->orderBy('id', 'desc')->first(); @endphp
                                       @if(!empty($Transfer->touserrelation->name))

                                       {{$Transfer->touserrelation->name}} from</br>
                                       {{$Transfer->department->name}} department

                                       @else
                                    <button type="button" class="btn btn-primary assignbtn" data-toggle="modal" data-target="#assignmodal" data-id="{{$item->id}}">
                                        Select
                                      </button>
                                       @endif

                                </td>
                                            <!-- <td>
                                                @if ($item->image)
    @php
        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
        
        $explodeImage = explode('.', "$item->image");
        $extension = end($explodeImage);
    @endphp
                                                @if (in_array($extension, $imageExtensions))
    <a href="{{ \Storage::disk('public')->url($item->image) }}" target="_blank">View In Full</a><br><img src="{{ \Storage::disk('public')->url($item->image) }}" alt="" srcset="" height="150px" width="150px">
@else
    <a href="{{ \Storage::disk('public')->url($item->image) }}" target="_blank">View In Full</a><br><img src="../dummyfile.png" alt="" srcset="" height="150px" width="150px">
    @endif
@else
    No Image
    @endif
                                            </td> -->

                                            <!-- <td>{{ optional($item->departmentrelation)->name ?? 'N/A' }}</td> -->

                                            <!-- <td>{{ optional($item->complaintsourcerelation)->name ?? 'Customer Complaint' }}</td> -->

                                        <th>
                                            @if (checkifresolved($item->id))
                                                Resolved
                                        </th>
                                        <td>
                                            
                                            <button type="button"
                                                class="btn btn-primary waves-effect complaintresolvebtn"
                                                data-toggle="modal" data-target="#view-data{{ $key + 1 }}">
                                                View
                                            </button>
                                        </td>
                                        <th>
                                        @else
                                            {{-- {{dd($item->complaintresoultionrelation)}} --}}


                                            <form action="{{ route('resolvecomplaintfront') }}"
                                                enctype="multipart/form-data" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="title" value="{{ $item->title }}">
                                                <input type="hidden" name="name" value="{{ $item->customername }}">
                                                <input type="hidden" name="uuid" value="{{ $item->uuid }}">
                                                <div class="form-group">
                                                    <label>Document</label>
                                                    <input type="file" id="document" name="document" />
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="exampleFormControlTextarea1" rows="4" cols="25" name="resolution" minlength="50"></textarea>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary btn-round btn-sm">Mark
                                                        as resolve</button>
                                                </div>
                                            </form>
                                        </th>


                                        </td>
                                        <td>
                                            <a href="editcomplaint/{{ $item->id }}"
                                                class="btn btn-primary waves-effect ">Edit</a>
                                            <button type="button"
                                                class="btn btn-primary waves-effect complaintresolvebtn"
                                                data-toggle="modal" data-target="#view-data{{ $key + 1 }}">
                                                View
                                            </button>
                                        </td>
                                        
                                @endif
                                
                                </tr>
                                <div class="modal fade" id="view-data{{ $key + 1 }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">Complaint</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">UUID </label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->uuid ?? 'N/A' }}</b></span>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Customer Name</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->customername ?? 'N/A' }}</b></span>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Mobile Number</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->mobile ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->email ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Complaint Title</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->title ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Details</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->details ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                                   <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"> File</label>
                                    @if ($item->image)
                                     <div class="col-sm-2"></div>
                                    <div class="col-sm-8">
                                    <a href="{{\Storage::disk('public')->url($item->image)}}" target="_blank">View In Full</a><br><img src="{{\Storage::disk('public')->url($item->image)}}" alt="" srcset="" height="50px" width="50px">
                                    </div>

                                    @else
                                      
                                    <div class="col-sm-10">
                                    @php $complaintattachment=App\Models\ComplaintAttachment::where('complaint_id', $item->id)->where('media_type', '0')->orderByDesc('id')->get();
 @endphp

                                    @if(!empty($complaintattachment))
                                    @php $ii= count($complaintattachment); 
                                                 for ($i = count($complaintattachment) - 1; $i >= 0; $i--) {
@endphp

<div class="col-md-2 d-inline-block mr-4">    <span class="pip"> <input type="button" value="x" class="remove_edit">  <a href="{{\Storage::disk('public')->url($complaintattachment[$i]->media_name)}}" target="_blank">View In Full</a><br><img src="{{asset('storage/'.$complaintattachment[$i]->media_name)}}" width="100px" height="100px" /><br/> Image-{{$ii}}
                                       <input type="hidden" name="old_images[]" value="{{$complaintattachment[$i]->media_name}}" /> </span></div>
                                       @php $ii--;} @endphp
                                   @else
                                   No Image
                                    
                                    @endif
                                    </div>

                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"> Video</label>

                                  @php $complaintattachmentvideo = App\Models\ComplaintAttachment::where('complaint_id', $item->id)->where('media_type', '1')->orderByDesc('id')->get();
 @endphp      
                                    @if(!empty($complaintattachmentvideo))
                                                                        <div class="col-sm-10">
                                    @php $ii= count($complaintattachmentvideo); 
                                                 for ($i = count($complaintattachmentvideo) - 1; $i >= 0; $i--) {
@endphp
<div class="col-md-2 d-inline-block mr-4">    <span class="pip"> <input type="button" value="x" class="remove_edit">  <a href="{{\Storage::disk('public')->url($complaintattachmentvideo[$i]->media_name)}}" target="_blank">View In Full</a><br>
<video width="320" height="240" controls>
      <source src="{{URL::asset('storage/'.$complaintattachmentvideo[$i]->media_name)}}" type="video/mp4">

</video>
<br/> Video-{{$ii}}
                                       <input type="hidden" name="old_videos[]" value="{{$complaintattachmentvideo[$i]->media_name}}" /> </span></div>
                                       @php $ii--;} @endphp
                                        </div>
                                        @else
                                      <div class="col-sm-10">No Video</div>  
                                    @endif
                                   
                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Complaint Department</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->departmentrelation->name  ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Complaint Source</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->complaintsourcerelation->name ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Customer Type</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->customer_type ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Customer Address</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->customer_address ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Customer City</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->customer_city ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Customer State</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->customer_state ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Invoice No</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->customer_invoice_no ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Purchase Date</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->purchase_date ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Delivary Date</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->delivary_date ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Product Name</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->product_name ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Product Category</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->product_category ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>



                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Product SKU</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->sku ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Product Batch No</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->batch_number ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Manufacturing Date </label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->mfg ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Production Facility </label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->production_facility ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Risk Category </label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->risk_category ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Complaint Type </label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->complaint_type ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                              <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Resolution</label>
                                                    <div class="col-sm-8">
                                                        <span><b>{{ $item->complaintresoultionrelation->resolution ?? 'N/A' }}</b></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button"
                                                    class="btn btn-primary waves-effect waves-light submitinquiryresolution">Ok
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
        $(document).ready(function() {
            $('#simpletable1').DataTable({
                "lengthMenu": [
                    [10],
                    [10, 20, 30, "All"]
                ],
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

            $("#mobile").change(function(e) {
                var mobileNum = $('#mobile').val();
                var validateMobNum = /^\d*(?:\.\d{1,2})?$/;
                if (validateMobNum.test(mobileNum) && mobileNum.length == 10) {
                    return true;
                } else {
                    $("#mobile").focus();
                    return false;
                }
            });

            $('#createcomplaint').on('submit', function() {
                var mobileNum = $('#mobile').val();
                var validateMobNum = /^\d*(?:\.\d{1,2})?$/;
                if (validateMobNum.test(mobileNum) && mobileNum.length == 10) {} else {
                    alert("Please Enter only 10 digit mobile no")
                    $("#mobile").focus();
                    return false;
                }

                var from = new Date($("#purchase").val());
                var to = new Date($("#delivary").val());

                if (from > to) {
                    alert("Invalid Date Range of Purchase and Delivary");
                    $("#delivary").focus();
                    return false;
                }

            });



            $('#createinquiry').on('submit', function() {
                var mobileNum = $('#inqmobile').val();
                var validateMobNum = /^\d*(?:\.\d{1,2})?$/;
                if (validateMobNum.test(mobileNum) && mobileNum.length == 10) {} else {
                    alert("Please Enter only 10 digit mobile no")
                    $("#mobile").focus();
                    return false;
                }


            });

        });
    </script>

    {{-- get state and city naeme  --}}
    <script>
        $(document).ready(function() {
            $.ajax('{{ route('state') }}', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                success: function(data, status, xhr) {
                    $.each(data, function(key, value) {
                        $('#state')
                            .append($("<option></option>")
                                .attr("value", value.state_name)
                                .text(value.state_name));
                    });
                },
                error: function(jqXhr, textStatus, errorMessage) {

                }
            });
        });
        function city_name() {
            var value = $('#state').val();
            $.ajax('{{ route('city')}}',{
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data:{'_token': '{{csrf_token()}}','state':value},
                success: function(data, status, xhr) {
                    $.each(data, function(key, value) {
                        $('#city')
                            .append($("<option></option>")
                                .attr("value", value.city_name)
                                .text(value.city_name));
                    });
                },
                error: function(jqXhr, textStatus, errorMessage) {

                }
            });                
        }
                if (window.File && window.FileList && window.FileReader) {
               $("#files_1").on("change", function(e) {
                  var files = e.target.files,
                     filesLength = files.length;
                     $("<div class=\"row\"><div class=\"col-md-12\">").insertAfter("#files_1");
                  for (var i = 0; i < filesLength; i++) {
                     var f = files[i]
                     var fileReader = new FileReader();
                     fileReader.onload = (function(theFile, count) {
                      return function(e) {
                        var file = e.target;
                        $("<div class=\"col-md-2 d-inline-block mr-4\"><span class=\"pip\">" +
                           "<input type=\"button\"  value=\"x\" class=\"remove\" /><img class=\"imageThumb\" style=\"width:120px;\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                           "<br/>" + "Image" + " " + "-" + count + "<br/></div>").insertAfter("#files_1");
                        $(".remove").click(function() {
                           $(this).parent(".pip").remove();
                        });
                     };
                     })(f,i+1);
                     fileReader.readAsDataURL(f);
                  }

                  $("</div></div>").insertAfter("#files_1");
               });
            } else {
               alert("Your browser doesn't support to File API")
            }
        function resetForm(event){
  
if($("input[name='fromdate']").val()!='' || $("input[name='cmptype']").val()!='' ||  $("input[name='cmpsource']").val()!=''
)
    {
   $('#date-filter')[0].reset();

   //// $('#date-filter').get(0).reset();

    window.location.href = "{{route('frontofficedashboard')}}";
    }
}
        </script>
        <div class="modal" id="assignmodal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Choose Complaint Department</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="POST">
            @csrf
            <!-- Modal body -->
        <div class="modal-body">
            <div class="form-group row">
                <input type="hidden" name="complaintid" id="complaintid">
                <div class="col-sm-12">
                    <select name="ct" class="form-control">
                        @foreach ($deparments as $item)
                        <option value="{{$item->id}}">{{$item->name ?? 'N/A'}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Assign</button>
        </div>
        </form>

      </div>
    </div>
  </div>
@endsection