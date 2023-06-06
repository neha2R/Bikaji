@extends('ceo.layout.app')
@section('content')
<div class="row">

    <div class="col-xl-3 col-md-6">
        <a href="{{route('ceocomplaint')}}">
            <div class="card bg-c-green text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Total <br> Complaints</p>
                            <h4 class="m-b-0">{{$totalcomplaints}}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-user f-50 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <input type="hidden" id="resolvedcomplaints" value="{{$resolvedcomplaints}}">
        <input type="hidden" id="pendingcomplaints" value="{{$pendingcomplaints}}">
        <input type="hidden" id="highprioritycomplaints" value="{{$highprioritycomplaints}}">
        <input type="hidden" id="crossedtlcomplaints" value="{{$crossedtlcomplaints}}">
        <a href="{{route('ceocomplaint', ['type' => 'pending'])}}">
            <div class="card bg-c-yellow text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Unresolved <br> Complaints</p>
                            <h4 class="m-b-0">{{$pendingcomplaints}}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-user f-50 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{route('ceoinquiry')}}">
            <div class="card bg-c-green text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Total <br> Inquiries</p>
                            <h4 class="m-b-0">{{$totalinquiries}}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-credit-card f-50 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <input type="hidden" id="resolvedinquiries" value="{{$resolvedinquiries}}">
        <input type="hidden" id="pendinginquiries" value="{{$pendinginquiries}}">
        <a href="{{route('ceoinquiry')}}">
            <div class="card bg-c-yellow text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">In-process <br> Inquiries</p>
                            <h4 class="m-b-0">{{$pendinginquiries}}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-credit-card f-50 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Complaints</h5>
            </div>
            <div class="card-block">
                <canvas id="complaintchart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Inquiries</h5>
            </div>
            <div class="card-block">
                <canvas id="inquirychart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection