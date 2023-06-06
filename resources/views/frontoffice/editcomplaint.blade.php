@extends('frontoffice.layout.app')
@section('content')

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-block">
                <div class="col-lg-12 col-xl-12 col-md-12">

<form method="POST" id="createcomplaint" action="{{route('editcomplaint',$comp->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" name="customername" id="name" value="{{$comp->customername}}" placeholder="Customer Name" required maxlength="50" >
                                        {!! $errors->first('customername', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Mobile Number</label>
                                    @if($comp->mobile=='N/A')
                                    {{$comp->mobile= ''}}
                                    @endif
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="mobile" value="{{$comp->mobile}}" name="mobile" placeholder="Mobile Number">
                                        {!! $errors->first('mobile', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                       @if($comp->email=='N/A')
                                    {{$comp->email=''}}
                                    @endif
                                    <div class="col-sm-10">
                                        <input type="email" value="{{$comp->email}}" class="form-control" name="email" placeholder="Enter Email" maxlength="50">
                                        {!! $errors->first('email', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" value="{{$comp->title}}" name="title" placeholder="Complaint Title" maxlength="100">
                                        {!! $errors->first('title', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Details</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" cols="5" class="form-control" name="details" placeholder="Details" maxlength="500">{{$comp->details}}</textarea>
                                        {!! $errors->first('details', '<p style="color: red" class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Upload File</label>
                                    <input type="file" id="files_1" style="display: block;" name="media_name[]" accept="image/*" multiple />

                                    <div class="col-sm-10">
                                    @if(!empty($complaintattachment))
                                    @php $ii= count($complaintattachment); 
                                                 for ($i = count($complaintattachment) - 1; $i >= 0; $i--) {
@endphp
<div class="col-md-2 d-inline-block mr-4">    <span class="pip"> <input type="button" value="x" class="remove_edit"> <img src="{{asset('storage/'.$complaintattachment[$i]->media_name)}}" width="100px" height="100px" /><br/> Image-{{$ii}}
                                       <input type="hidden" name="old_images[]" value="{{$complaintattachment[$i]->media_name}}" /> </span></div>
                                       @php $ii--;} @endphp
                                   
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Upload Video</label>
                                    <input type="file" id="files_1" style="display: block;" name="media_video[]" accept="video/*" multiple />
                                    <div class="col-sm-10">
                                    @if(!empty($complaintattachmentvideo))
                                    @php $ii= count($complaintattachmentvideo); 
                                                 for ($i = count($complaintattachmentvideo) - 1; $i >= 0; $i--) {
@endphp
<div class="col-md-2 d-inline-block mr-4">    <span class="pip"> <input type="button" value="x" class="remove_edit"> <img src="{{asset('storage/'.$complaintattachmentvideo[$i]->media_name)}}" width="100px" height="100px" /><br/> Video-{{$ii}}
                                       <input type="hidden" name="old_videos[]" value="{{$complaintattachmentvideo[$i]->media_name}}" /> </span></div>
                                       @php $ii--;} @endphp
                                   
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Department</label>
                                    <div class="col-sm-10">

                                        <select name="ct" class="form-control">
                                        <option value="">Select Department</option>
                                            @foreach ($deparments as $item)
                                           @if($item->id == $comp->complainttype)
                                           @php $selected = 'selected="se;ected"'; @endphp
                                           @else
                                           @php $selected = ''; @endphp
                                           @endif
                                            <option {{$selected}} value="{{$item->id}}">{{$item->name ?? 'N/A'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Source</label>
                                    <div class="col-sm-10">
                                        <select name="cs" class="form-control">
                                            @foreach ($complaintsource as $item)
                                            @if($item->id == $comp->complaintsource)
                                           @php $selected2 = 'selected="se;ected"'; @endphp
                                           @else
                                           @php $selected2 = ''; @endphp
                                           @endif
                                            <option {{$selected2}} value="{{$item->id}}">{{ucwords($item->name ?? 'N/A')}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer Type</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"
                                        value="{{$comp->customer_type}}" name="customer_type" placeholder="Customer Type" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"
                                        value="{{$comp->customer_address}}" name="customer_address" placeholder="Customer Address" maxlength="250">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer City</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$comp->customer_city}}" name="customer_city" placeholder="Customer City" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Customer State</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{$comp->customer_state}}"class="form-control" name="customer_state" placeholder="Customer State" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Invoice No</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$comp->customer_invoice_no}}"name="customer_invoice_no" placeholder="Invoice No" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Purchase Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="purchase" value="date('Y-m-d',strtotime({{$comp->purchase_date}}))"name="purchase_date" placeholder="Purchase Date" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Expiry Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="delivery" name="delivery_date" value="{{$comp->delivery_date}}"placeholder="Delivary Date">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" value="{{$comp->product_name}}" name="product_name" placeholder="Product Name" maxlength="50">
                                    </div>
                                </div>
                           <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Category</label>
                                    <div class="col-sm-10">
                                        @if(!empty($comp->product_categoryid))
                                        <select name="pc" class="form-control">
                                            @foreach ($category as $item)
                                            @if($item->id == $comp->product_categoryid)
                                           @php $selected2 = 'selected="se;ected"'; @endphp
                                           @else
                                           @php $selected2 = ''; @endphp
                                           @endif
                                            <option {{$selected2}} value="{{$item->id}}">{{ucwords($item->name ?? 'N/A')}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <input type="text" class="form-control text"
                                        value="{{$comp->product_category}}" name="product_category" placeholder="Product Category" maxlength="100">

                                        @endif
                                    </div>
                                </div>
                              <!---  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Category</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text"
                                        value="{{$comp->product_category}}" name="product_category" placeholder="Product Category" maxlength="100">
                                    </div>
                                </div>---->



                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product SKU</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{$comp->sku}}" class="form-control" name="sku" placeholder="Product SKU" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product Batch No</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="batch_number" value="{{$comp->batch_number}}" placeholder="Product Batch No" maxlength="150">
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
                                        
                                       
                                                          <a href="{{ \Storage::disk('public')->url($comp->batch_image) }}"
                                                        target="_blank">View In Full</a><br><img
                                                        src="{{ \Storage::disk('public')->url($comp->batch_image) }}"
                                                        alt="" srcset="" height="50px" width="50px">
                                        <input type="file" class="form-control" name="batchfile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Manufacturing Date </label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" value="{{$comp->mfg}}" name="mfg" placeholder="Manufacturing Date">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Production Facility </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" value="{{$comp->production_facility}}" name="production_facility" placeholder="Production Facility" maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Risk Category</label>
                                    <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio1" <?php if($comp->risk_category=='vh') { echo "checked";}?> value="vh" />
  <h1 style="background-color:#ff0000;font-size:17px;width: 48%;">Very High</h1>
</div>

<div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio2" <?php if($comp->risk_category=='hi') { echo "checked";}?> value="hi" />
  <h1 style="background-color:#ffc100;font-size:17px;width: 25%;">High</h1>
</div>

<div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio3" <?php if($comp->risk_category=='me') { echo "checked";}?> value="me"  />
  <h1 style="background-color:#ffff00;font-size:17px;width: 42%;">Medium</h1>
</div>

<div class="col-sm-3">
  <input class="form-control" type="radio" name="inlineRadioOptions" id="inlineRadio3" <?php if($comp->risk_category=='lo') { echo "checked";}?> value="lo"  />
  <h1 style="background-color:#00cd00;font-size:17px;width: 22%;">Low</h1>
</div>
                                            </div>
                                        
                                    </div>
                                </div>
                                

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Complaint Type </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text" name="complaint_type" value="{{$comp->complaint_type}}" placeholder="Complaint Type" maxlength="100">
                                    </div>
                                </div>


                                <button class="btn btn-primary">Update Complaint</button>

                            </form>
                            </div>

</div>
</div>
</div>
</div>
</div>
@endsection

@section('js')
<script>
 $('.text').on('keypress', function(e) {
          var regex = new RegExp("^[a-zA-Z ]*$");
          var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
          if (regex.test(str)) {
             return true;
          }
          e.preventDefault();
          return false;
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
        var from = new Date($("#purchase").val());
        var to = new Date($("#delivary").val());

        if(from > to){
        alert("Invalid Date Range of Purchase and Delivary");
        $("#delivary").focus();
            return false;
        }

        });
        $(document).on('click', ".remove_edit", function() {
         $(this).parent(".pip").remove();
         $(this).val('');


      });
</script>
@endsection
