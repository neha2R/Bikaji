@extends('frontoffice.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Front Office/Call center executive dashboard</h3>
            </div>
            {{-- <div class="card-block">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-yellow text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Total grievances</p>
                                        <h4 class="m-b-0">852</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-user f-50 text-c-yellow"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-green text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Total enquiries</p>
                                        <h4 class="m-b-0">5,852</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-credit-card f-50 text-c-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-pink text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Ticket</p>
                                        <h4 class="m-b-0">42</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-book f-50 text-c-pink"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> --}}
        </div>
    </div>
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Complaint Dashboard</h3>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-yellow text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                     <a href="{{route('frontofficedashboard')}}">
                                        <p class="m-b-5">Total grievances (Dashboard)</p>
                                        <h4 class="m-b-0">{{$totalcomplaints}}</h4>
                                        </a>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-user f-50 text-c-yellow"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-green text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                      <a href="http://127.0.0.1:8000/frontoffice/dashboard?type=resolved">
                                        <p class="m-b-5">Closed grievances (Dashboard)</p>
                                        <h4 class="m-b-0">{{$resolvedcomplaints}}</h4>
                                        </a>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-credit-card f-50 text-c-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        {{-- <div class="card bg-c-pink text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Ticket</p>
                                        <h4 class="m-b-0">42</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-book f-50 text-c-pink"></i>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
            
            
           
            
        </div>
    </div>
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Inquiry Dashboard</h3>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-yellow text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                    <a href="{{route('inquirydashboard')}}">
                                        <p class="m-b-5">Total inquiries</p>
                                        <h4 class="m-b-0">{{$totalinquiries}}</h4>
                                        </a>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-user f-50 text-c-yellow"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-c-green text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Closed inquiries</p>
                                        <h4 class="m-b-0">{{$resolvedinquiries}}</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-credit-card f-50 text-c-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        {{-- <div class="card bg-c-pink text-white">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="m-b-5">Ticket</p>
                                        <h4 class="m-b-0">42</h4>
                                    </div>
                                    <div class="col col-auto text-right">
                                        <i class="feather icon-book f-50 text-c-pink"></i>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
