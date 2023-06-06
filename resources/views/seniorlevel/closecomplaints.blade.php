@extends('seniorlevel.layout.slevelapp')
@section('content')
<script src="{{URL::asset('files\assets\js\frontoffice.js')}}"></script>
<script src="{{URL::asset('files\assets\js\readmore.js')}}"></script>
<style>
    .readmorediv {
        overflow: hidden;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <!-- Zero config.table start -->
        <div class="card">
            <div class="card-header">
                <h5>Complaint</h5>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="closecomplainttable" class="table table-striped table-bordered complainttable">
                        <thead>
                            <tr>
                                <th>C.No</th>
                                <th>Customer Name</th>
                                <th>Mob</th>
                                <th>Complaint Details</th>
                                <th>Resolution</th>
                                <th>Complaint Register Date</th>
                                <th>Complaint Resolution Date</th>
                                <th>Resolved on time</th>
                                <th>Resolve Doc</th>
                                <th>Close Complaint</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            @if (checkifresolved(optional($item->complaint)->id))
                            <tr>
                                <td>{{$item->complaint->uuid ?? 'N/A'}}</td>
                                <td>{{$item->complaint->customername ?? 'N/A'}}</td>
                                <td>{{$item->complaint->mobile ?? 'N/A'}}</td>
                                <th >{{$item->complaint->details ?? 'N/A'}}</th>
                                <th >{{getresolution(optional($item->complaint)->id)->resolution ?? 'N/A'}}</th>
                                <!-- <td>
                                    {{-- <p class="readmorediv" style="margin: 0;"> --}}
                                    @php
                                        $myString = getresolution(optional($item->complaint)->id)->resolution;
                                        echo '<pre class="readmorediv" style="margin: 0;font-family: system-ui;font-size: 100%;">' . wordwrap( $myString ) . '</pre>';
                                    @endphp
                                    {{-- </p> --}}
                                    {{-- @php
                                    $array = str_split(getresolution(optional($item->complaint)->id)->resolution, 20);
                                    @endphp
                                    <p class="readmorediv" style="margin: 0;">
                                        @php
                                            echo implode("<br>",$array);
                                        @endphp
                                    </p> --}}
                                </td> -->
                                <td>{{date('j F, Y', strtotime(getcomplaintregisterdate($item->complaintid)))}}</td>
                                <td>{{date('j F, Y', strtotime(getresolution($item->complaintid)->updated_at))}}</td>
                                <td>
                                    @if (getevaluation($item->complaintid))
                                    Yes
                                    @else
                                    No
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item->evaluation))
                                    <a href="{{\Storage::disk('public')->url($item->evaluation->document)}}" target="_blank">View In Full</a>
                                    <br><img src="{{\Storage::disk('public')->url($item->evaluation->document)}}" alt="" srcset="" height="150px" width="150px">
                                    @else
                                        No Doc
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary closecomplaintbtn" data-toggle="modal"
                                        data-target="#closecomplaintmodal" data-id="{{optional($item->complaint)->id}}">
                                        @if (checkifsenior($item->complaintid))
                                            Close Complaint
                                        @else
                                           Approve Resolution
                                        @endif
                                    </button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Zero config.table end -->
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="closecomplaintmodal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Close Complaint</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="id" id="complaintid">
                    <p style="font-size: 20px;">Are you sure you want to close this complaint?</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Yes</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
