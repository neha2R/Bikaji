@extends('frontoffice.layout.app')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{URL::asset('files/assets/js/frontoffice.js')}}"></script>
<style>
#smalll
{

    white-space: normal;
}
.icon-pencil:before {
    content: "\e90e";
}
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
<script>
$(document).ready(function() {
$('html, body, *').mousewheel(function(e, delta) {
      this.scrollLeft -= (delta * 60);
e.preventDefault();
});
});
</script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
             <h5>Customer Complaints</h5>
            </div>
            <form id="date-filter" action="{{route('customercomplaintslist')}}">
                           <div class="row justify-content-end">
                              <!---<div class="ml-2">
                                 <label>From</label>
                              </div>-->
                             <!--- <div class="ml-2">
                                 <input type="date" name="from" id="from_date" value="{{request()->from}}" class="form-control" />
                              </div>
                              <div class="ml-2">
                                 <label>To</label>
                              </div>
                              <div class="ml-2">
                                 <input type="date" name="to" id="to_date" value="{{request()->to}}" class="form-control" />
                              </div>-->
                              <div style="margin-right: 80px;">
                                 <input type="submit" class=" btn btn-success btn-sm ml-3" name="export" value="Export to Excel">
                              </div>
                             <!--- <div style="margin-right:30px">
                                 <a href="#" target="_blank" class=" btn btn-success btn-sm " id="print_all">Print</a>
                              </div>-->
                           </div>
                        </form>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                              <th>S.no.</th>
                                <th>Customer Name</th>
                                <th>Mobile Number</th>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Complaint Source</th>
                                <th>File</th>
                                <th>Assign Department</th>
                                <th>Issue Resolve</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($data as $key => $item)
                              <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->customername}}</td>
                                <td>{{$item->mobile}}</td>
                                    @php
                              $title=  wordwrap($item->title,15,"<br>\n");
                               $titledetail=  wordwrap($item->details,50,"<br>\n");
                                @endphp
                                <td>{!! $title !!}</td>
                            
                                <td>{!! $titledetail !!}</td>
                                <td style="text-align: center">{{App\Models\ComplaintSource::find($item->complaintsource)->name ?? '-'}}</td>
                                <td>
                                  @if ($item->image)
                                    <a href="{{\Storage::disk('public')->url($item->image)}}" target="_blank">View In Full</a><br><img src="{{\Storage::disk('public')->url($item->image)}}" alt="" srcset="" height="50px" width="50px">
                                    @else
                                        No Image
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-primary assignbtn" data-toggle="modal" data-target="#assignmodal" data-id="{{$item->id}}">
                                        Select
                                      </button>


                                </td>
 
                                @if (checkifresolved($item->id))
<th>
                                Resolved
</th>
                                @else

                        <th id="smalll"> <form action="{{route('resolvecomplaintfront')}}" enctype="multipart/form-data" method="post">
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
                                  @endif
                                <td>  <a href="editcomplaint/{{$item->id}}"><i class="fa fa-pencil-square fa-2x"></i></a>
                                <a class="complaintresolvebtn" data-toggle="modal"
                                    data-target="#view-data{{$key + 1}}">
<i class="fa fa-eye fa-2x" aria-hidden="true"></i>

                                    </a>
                              </td>


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
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


  <!-- The Modal -->
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
                        @foreach ($departments as $item)
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
