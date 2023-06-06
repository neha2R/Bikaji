@extends('seniorlevel.layout.slevelapp')
@section('content')
<script src="{{URL::asset('files/assets/js/frontoffice.js')}}"></script>
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
                <h5>Inquiry</h5>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered complainttable">
                        <thead>
                            <tr>
                                <th>C.No</th>
                                <th>Customer Name</th>
                                <th>Mob</th>
                                <th>Inquiry Details</th>
                                <th>Resolution</th>
                                <th>Inquiry Register Date</th>
                                <th>Inquiry Resolution Date</th>
                                <th>Resolved on time</th>
                                <th>Close Inquiry</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            @if (inquirycheckifresolved(optional($item->inquiry)->id))
                            <tr>
                                    <td>{{$item->inquiry->uuid ?? 'N/A'}}</td>
                            <td>{{$item->inquiry->customername ?? 'N/A'}}</td>
                            <td>{{$item->inquiry->contact ?? 'N/A'}}</td>
                            <th>{{$item->inquiry->details ?? 'N/A'}}</th>
                            <th>{{inquirygetresolution(optional($item->inquiry)->id)->resolution ?? 'N/A'}}</th>
                            <!-- <td>
                                @php
                                $myString = inquirygetresolution(optional($item->inquiry)->id)->resolution;
                                echo '
                                <pre class="readmorediv"
                                    style="margin: 0;font-family: system-ui;font-size: 100%;">' . wordwrap( $myString ) . '</pre>
                                ';
                                @endphp

                            </td> -->
                            <td>{{date('j F, Y', strtotime(getinquiryregisterdate($item->inquiryid)))}}</td>
                            <td>{{date('j F, Y', strtotime(inquirygetresolution($item->inquiryid)->updated_at))}}</td>
                            <td>
                                @if (inquirygetevaluation($item->inquiryid))
                                Yes
                                @else
                                No
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary closecomplaintbtn" data-toggle="modal"
                                    data-target="#closecomplaintmodal" data-id="{{optional($item->inquiry)->id}}">
                                    @if (inquirycheckifsenior($item->inquiryid))
                                        Close Inquiry
                                    @else
                                        Approve resolution
                                    @endif
                                </button>
                            </td>
                            </tr>
                            @endif
                            @endforeach

                            {{-- @foreach ($frontinq as $item)
                            @if (!checkifinquiryclosed($item->id))
                            <tr>
                                <td>{{$item->uuid ?? 'N/A'}}</td>
                                <td>{{$item->customername ?? 'N/A'}}</td>
                                <td>{{$item->contact ?? 'N/A'}}</td>
                                <td>{{$item->details ?? 'N/A'}}</td>
                                <td>
                                    @php
                                    $myString = inquirygetresolution($item->id)->resolution;
                                    echo '
                                    <pre class="readmorediv"
                                        style="margin: 0;font-family: system-ui;font-size: 100%;">' . wordwrap( $myString ) . '</pre>
                                    ';
                                    @endphp

                                </td>

                                <td>{{date('j F, Y', strtotime(getinquiryregisterdate($item->id)))}}</td>
                                <td>{{date('j F, Y', strtotime(inquirygetresolution($item->id)->updated_at))}}</td>
                                <td>
                                    @if (inquirygetevaluation($item->id))
                                    Yes
                                    @else
                                    No
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary closecomplaintbtn" data-toggle="modal"
                                        data-target="#closecomplaintmodal" data-id="{{$item->id}}">
                                        Close Inquiry
                                    </button>
                                </td>
                            </tr>
                            @endif
                            @endforeach --}}
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
                    <p style="font-size: 20px;">Are you sure you want to close this inquiry?</p>
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
