@extends('juniorlevel.layout.jlevelapp')
@section('content')
<script src="{{URL::asset('files\assets\js\tabpanel-custom.js')}}"></script>

<div class="row" style="margin-bottom: 10px;">

<div class="row">
 <div class="col-md-3">
        <a href="{{route('jinquiry')}}" class="btn btn-primary">Remove Filters</a>
    </div>
    <div class="col-md-3" style="text-align: center;">
        <div class="dropdown-primary dropdown open">
            <button class="btn btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @switch(request()->get('type'))
                @case('resolved')
                   Resolved Inquiries
                    @break
               
                @case('pending')
                    Pending Inquiries
                    @break
                @default
                    All Inquiries
            @endswitch
            </button>
            <input type="hidden" id="type" name="type" value="<?php echo request()->get('type');?>">

            <input type="hidden" id="cmptype" name="cmptype" value="<?php echo request()->get('type');?>">
            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn"
                data-dropdown-out="fadeOut" x-placement="top-start"
                style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
              
                    <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'pending'])}}">Pending Inquiries</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'resolved'])}}">Resolved Inquiries</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{route('jinquiry')}}">All Inquiries</a>
            </div>
        </div>
    </div>
    <input type="hidden" id="inqsource" name="inqsource" value="<?php echo request()->get('inqsource');?>">

<div class="col-md-3" style="text-align: center;">
    <div class="dropdown-primary dropdown open">
        <button class="btn btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inquiry Source</button>
        <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn"
            data-dropdown-out="fadeOut" x-placement="top-start"
            style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform; height:200px; overflow-y:scroll;">
            @if (count($inquirysource))
            @foreach ($inquirysource as $item)
            <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['inqsource' => $item->id])}}">{{$item->name}}</a>
            @endforeach
            @endif
        </div>
    </div>
</div>
   
    <div class="col-md-4" style="margin-top:20px;">
    <form method="GET" id="datefilter">
            <div id="reportrange"
                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                @if (request()->has('startdate') && request()->has('enddate'))
                    <input type="hidden" id="checkfirst" value="0">
                    <span id="daterange">{{date('F j, Y', strtotime(request()->get('startdate')))}} - {{date('F j, Y', strtotime(request()->get('enddate')))}}</span>
                    @else
                    <input type="hidden" id="checkfirst" value="1">
                    <span id="daterange"></span>
                @endif
                <i class="fa fa-caret-down"></i>
            </div>
            <input type="hidden" id="startdate" name="startdate" value="" />
            <input type="hidden" id="enddate" name="enddate" value="" />
            </form>

            <form id="date-filter"  action="{{route('jinquiry')}}">

<input type="hidden" id="startdate" name="startdate" value="<?php echo request()->get('startdate');?>">
                                  <input type="hidden" id="enddate" name="enddate" value="<?php echo request()->get('enddate');?>">
  <input type="hidden" id="inqsource" name="inqsource" value="<?php echo request()->get('inqsource');?>">
                                  <input type="hidden" id="type" name="type" value="<?php echo request()->get('type');?>"></br>
                  <input type="submit" class="btn btn-primary" name="export" value="Export to Excel">    
                  </form>
    
    </div>
</div>
</div>
<div class="row">
    <div class="col-sm-12">
        <!-- Zero config.table start -->
        <div class="card">
            <div class="card-header">
                <h5>Inquiry</h5>
                {{-- <span>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</span> --}}
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap inquirytable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>C.No</th>
                                <th>Customer Name</th>
                                <th>Mob</th>
                                <th>Inquiry Details</th>
                                {{-- <th>Remaining Days</th> --}}
                                {{-- <th>Transfer</th> --}}
                                <th>Resolve</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            {{-- {{dd($item)}} --}}
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->uuid ?? 'N/A'}}</td>
                                <td>{{$item->customername ?? 'N/A'}}</td>
                                <td>{{$item->contact ?? 'N/A'}}</td>
                                <th>{{$item->details ?? 'N/A'}}</th>
                                {{-- <td>{{today()->diffInDays($item->created_at->addDays(7))}}</td> --}}
                                {{-- <td>
                                    <select class="js-example-basic-single col-sm-12 transferinquiry" id="{{$item->id}}">
                                        <option>Click to Select</option>
                                        @foreach ($departments as $department)
                                        <optgroup label="{{$department->name}}">
                                            @foreach ($department->users as $user)
                                            @if ($user->id != auth()->user()->id)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>

                                </td> --}}
                                <td>
                                    @if (inquirycheckifresolved($item->id))
                                    Resolved
                                    @else
                                    <button type="button" class="btn btn-primary waves-effect inquiryresolvebtn"
                                        data-id="{{$item->id}}" data-fromuser="{{$item->createdby}}" data-departmentid="{{$item->inquirysource}}" data-toggle="modal" data-target="#resolve-Modal">
                                        Resolve
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Zero config.table end -->
    </div>
</div>

<div class="modal fade" id="resolve-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="{{ route('resolveinquiry') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Resolution</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <input type="hidden" name="id" id="inquiryid">
                        <input type="hidden" name="fromuser" id="fromuser">
                        <input type="hidden" name="departmentid" id="departmentid">
                        <div class="form-group">
                                                <label>Document</label>
                                                    <input type="file" id="document" name="document"  required/>
                                                </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Details of resolution</label>
                            <div class="col-sm-9">
                                <textarea rows="5" cols="5" class="form-control" name="resolution"
                                    id="resolution" minlength="140" required></textarea>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light submitinquiryresolution">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
    $(function() {
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var startsend = picker.startDate.format('L');
            var endsend = picker.endDate.format('L');
            $('#startdate').val(startsend);
            $('#enddate').val(endsend);
            $('#datefilter').submit();
        });
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start
            , endDate: end
            , ranges: {
                'Today': [moment(), moment()]
                , 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')]
                , 'Last 7 Days': [moment().subtract(6, 'days'), moment()]
                , 'Last 30 Days': [moment().subtract(29, 'days'), moment()]
                , 'This Month': [moment().startOf('month'), moment().endOf('month')]
                , 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        var checkfirst = $('#checkfirst').val();
        if (parseInt(checkfirst)) {
            cb(start, end);
        }

    });

</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function(){
        $('.detailsmodalbtn').each(function(){
            $(this).click(function(){
                var details = $(this).attr('data-details');
                $('#inqdetails').html(details);
            });
        });
    });
    </script>
@endsection
