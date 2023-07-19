@extends('ceo.layout.app')
@section('content')
<script src="{{URL::asset('files\assets\js\tabpanel-custom.js')}}"></script>
<div class="row" style="margin-bottom: 10px;">
   
    <div class="row">
 <div class="col-md-3">
        <a href="{{route('ceoinquiry')}}" class="btn btn-primary">Remove Filters</a>
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
                    <a class="dropdown-item waves-light waves-effect" href="{{route('ceoinquiry')}}">All Inquiries</a>
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
    <div class="col-md-3">
        <div class="dropdown-primary dropdown open">
            <button class="btn btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter by Employees</button>
            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn"
                data-dropdown-out="fadeOut" x-placement="top-start"
                style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform; height:200px; overflow-y:scroll;">
                @if (count($users))
                    @foreach ($users as $item)
                        <a class="dropdown-item waves-light waves-effect" href="?employee={{$item->id}}">{{$item->name}}</a>
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

            <form id="date-filter"  action="{{route('ceoinquiry')}}">

<input type="hidden" id="startdate" name="startdate" value="<?php echo request()->get('startdate');?>">
                                  <input type="hidden" id="enddate" name="enddate" value="<?php echo request()->get('enddate');?>">
  <input type="hidden" id="inqsource" name="inqsource" value="<?php echo request()->get('inqsource');?>">
                                  <input type="hidden" id="type" name="type" value="<?php echo request()->get('type');?>">
                                                             <input type="hidden" id="employee" name="employee" value="<?php echo request()->get('employee');?>"></br>
                  <input type="submit" class="btn btn-primary" name="export" value="Export to Excel">    
                  </form>
    
    </div>
</div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-block">
                <div class="col-lg-12 col-xl-12 col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#home7" id="homelink" role="tab"><i
                                    class="icofont icofont-home"></i>Resolved Inquiries</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#profile7" id="profilelink" role="tab"><i
                                    class="icofont icofont-ui-user "></i>Pending Inquiries</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content card-block">
                        <div class="tab-pane" id="home7" role="tabpanel">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>UUID</th>
                                            <th>Customer Name</th>
                                            <th>Mobile</th>
                                            <th>Details</th>
                                            {{-- <th>Department</th> --}}
                                            {{-- <th>Inquiry Source</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($resolvedinquiries as $key => $item)
                                        <tr>
                                            <th>{{$key + 1}}</th>
                                            <th>
                                                <a href="/ceo/trackinquiryceo?refno={{$item->uuid}}" target="_blank" title="Track this inquiry" data-toggle="tooltip" data-placement="right">{{$item->uuid ?? 'N/A'}}</a>
                                            </th>
                                            <th>{{$item->customername ?? 'N/A'}}</th>
                                            <th>{{$item->contact ?? 'N/A'}}</th>
                                            <th>
                                                <div class="animation-model">
                                                    <button type="button"
                                                        class="btn btn-primary btn-outline-primary waves-effect md-trigger detailsmodalbtn"
                                                        data-toggle="modal" data-target="#detailsmodal" data-details="{{$item->details ?? 'N/A'}}">
                                                        Details
                                                    </button>
                                                </div>
                                            </th>
                                            {{-- <th>{{optional($item->departmentrelation)->name ?? 'N/A'}}
                                            </th> --}}
                                            {{-- <th>{{optional($item->inquirysourcerelation)->name ?? 'Customer Inquiry'}} --}}
                                            </th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane active" id="profile7" role="tabpanel">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered nowrap tab-table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>UUID</th>
                                            <th>Customer Name</th>
                                            <th>Mobile</th>
                                            <th>Details</th>
                                            {{-- <th>Department</th> --}}
                                            {{-- <th>Inquiry Source</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (request()->has('employee'))
                                        @foreach ($pendinginquiries as $key => $item)
                                        <tr>
                                            <th>{{$key + 1}}</th>
                                            <th>
                                                <a href="/ceo/trackinquiryceo?refno={{$item->uuid}}" target="_blank" title="Track this inquiry" data-toggle="tooltip" data-placement="right">{{$item->uuid ?? 'N/A'}}</a>
                                            </th>
                                            <th>{{$item->customername ?? 'N/A'}}</th>
                                            <th>{{$item->contact ?? 'N/A'}}</th>
                                            <th>
                                                <div class="animation-model">
                                                    <button type="button"
                                                        class="btn btn-primary btn-outline-primary waves-effect md-trigger detailsmodalbtn"
                                                        data-toggle="modal" data-target="#detailsmodal" data-details="{{$item->details ?? 'N/A'}}">
                                                        Details
                                                    </button>
                                                </div>
                                            </th>
                                            {{-- <th>{{optional($item->departmentrelation)->name ?? 'N/A'}}</th> --}}
                                            {{-- <th>{{optional(optional($item)->inquirysourcerelation)->name ?? 'Customer Inquiry'}}</th> --}}
                                        </tr>
                                        @endforeach
                                        @else
                                        @foreach ($pendinginquiries as $key => $item)
                                        <tr>
                                            <th>{{$key + 1}}</th>
                                            <th>
                                                <a href="/ceo/trackinquiryceo?refno={{$item->uuid ?? 'N/A'}}" target="_blank" title="Track this inquiry" data-toggle="tooltip" data-placement="right">{{$item->uuid ?? 'N/A'}}</a>
                                            </th>
                                            <th>{{$item->customername ?? 'N/A'}}</th>
                                            <th>{{$item->contact ?? 'N/A'}}</th>
                                            <th>
                                                <div class="animation-model">
                                                    <button type="button"
                                                        class="btn btn-primary btn-outline-primary waves-effect md-trigger detailsmodalbtn"
                                                        data-toggle="modal" data-target="#detailsmodal" data-details="{{$item->details ?? 'N/A'}}">
                                                        Details
                                                    </button>
                                                </div>
                                            </th>
                                            {{-- <th>{{optional($item->departmentrelation)->name ?? 'N/A'}}</th> --}}
                                            {{-- <th>{{optional($item->inquirysourcerelation)->name ?? 'Customer Inquiry'}}</th> --}}
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- details modal --}}
<div class="modal fade" id="detailsmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Details of the Inquiry</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="inqdetails">
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Ok</button>
            </div>
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
    $('#homelink').click(function() {
        $("#profile7").hide();

});
$('#profilelink').click(function() {
        $("#profile7").show();

});
</script>
@endsection
