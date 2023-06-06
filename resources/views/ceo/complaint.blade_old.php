@extends('ceo.layout.app')
@section('content')
<style>
    .modalspan{
        padding: 5px;
    }
</style>
<script src="{{URL::asset('files\assets\js\tabpanel-custom.js')}}"></script>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-2">
        <a href="{{route('ceocomplaint', ['type' => 'crossedtl'])}}" class="btn btn-primary">Remove Filters</a>
    </div>
    <div class="col-md-3" style="text-align: center;">
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
            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn"
                data-dropdown-out="fadeOut" x-placement="top-start"
                style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'crossedtl'])}}">Complaints with Crossed
                    Timeline</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'pending'])}}">Pending Complaints</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['type' => 'resolved'])}}">Resolved Complaints</a>
                    <a class="dropdown-item waves-light waves-effect" href="{{route('ceocomplaint')}}">All Complaints</a>
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
                <a class="dropdown-item waves-light waves-effect" href="{{ request()->fullUrlWithQuery(['employee' => $item->id])}}">{{$item->name}}</a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
            @if (request()->has('employee'))
            <input type="hidden" id="employee" name="employee" value="{{request()->get('employee')}}" />
            @endif
            @if (request()->has('type'))
            <input type="hidden" id="type" name="type" value="{{request()->get('type')}}" />
            @endif
        </form>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    @switch(request()->get('type'))
                        @case('resolved')
                            Resolved Complaints
                            @break
                        @case('crossedtl')
                            Complaints with Crossed Timeline
                            @break
                        @case('pending')
                            Pending Complaints
                            @break
                        @default
                            All Complaints
                    @endswitch
                    
                </h5>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    @php
                        $i = 1;
                    @endphp
                    <table id="simpletable" class="table table-striped table-bordered nowrap complainttable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>UUID</th>
                                <th>Days In System</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <th>{{$i}}</th>
                                <th> <a href="/ceo/trackcomplaintceo?refno={{optional($item->complaint)->uuid}}" target="_blank" title="Track this complaint" data-toggle="tooltip" data-placement="right">{{optional($item->complaint)->uuid ?? 'N/A'}}</a></th>
                                <th>
                                    <label
                                        @if (request()->has('crossedtl'))
                                        class="label badge-danger"
                                        @else
                                        class="label badge-primary"
                                        @endif>
                                        @if (optional($item->complaint)->created_at)
                                        {{optional($item->complaint)->created_at->diffInDays(now()) ?? 'N/A'}}
                                        Days
                                        @endif
                                    </label><br>
                                    <label class="label badge-warning">Created On
                                        :{{ datefomat(optional($item->complaint)->created_at)}}</label>
                                </th>
                                <th>
                                    <div class="animation-model">
                                        <button type="button"
                                            class="btn btn-primary btn-outline-primary waves-effect md-trigger detailsmodalbtn"
                                            data-toggle="modal" data-target="#detailsmodal" data-details="{{$item}}"
                                            @if (optional($item->complaint)->image)
                                            data-img='<img src="{{\Storage::disk('public')->url(optional($item->complaint)->image)}}" style="max-width: 300px;max-height: 200px;"/>'
                                            data-imglink="{{\Storage::disk('public')->url(optional($item->complaint)->image)}}"
                                            @else
                                                data-img="No Image"
                                                data-imglink=""
                                            @endif
                                            >
                                            Details
                                        </button>
                                    </div>
                                </th>
                            </tr>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- details modal --}}
<div class="modal fade" id="detailsmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Details of the Complaint</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <span class="text-primary modalspan">Customer name:</span> <span class="modalspan" id="custname"></span> <br>
                    <span class="text-primary modalspan">Mobile number:</span> <span class="modalspan" id="custcontact"></span> <br>
                    <span class="text-primary modalspan">Product Image:</span> <span class="modalspan" id="custimg"></span> <br>
                    <span class="text-primary modalspan"><a href="" id="imglink" target="_blank">Click here to see the full image</a></span> <br>
                    <span class="text-primary modalspan">Details:</span> <span class="modalspan" id="custdetails"></span>
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
            $('#daterange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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
                var img = $(this).attr('data-img');
                var imglink = $(this).attr('data-imglink');
                var comdet = JSON.parse(details);
                $('#custname').html(comdet['complaint']['customername']);
                $('#custcontact').html(comdet['complaint']['mobile']);
                $('#custimg').html(img);
                if (imglink) {
                    $('#imglink').show();
                    $('#imglink').attr('href', imglink);
                } else {
                    $('#imglink').hide();
                }
                $('#custdetails').html(comdet['complaint']['details'])
            });
        });
    });
</script>

@endsection