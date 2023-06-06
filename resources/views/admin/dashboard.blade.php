@extends('admin.layout.adminapp')
@section('content')


    <!-- statustic-card start -->
    <div class="row">

        <div class="col-xl-4 col-md-4">
            <div class="card bg-c-yellow text-white">
                <div class="card-block">
                    <div class="row align-items-center">

                        <div class="col">
                             <a href="{{route('adminemployee')}}">
                            <p class="m-b-5">Total Employee</p>
                            <h4 class="m-b-0">{{$totalemployee ?? 'N/A'}}</h4>
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
            <div class="card bg-c-blue text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <a href="{{route('totalcomplaints')}}">
                            <p class="m-b-5">Total Grievances</p>
                            <h4 class="m-b-0">{{$totalgivieance ?? 'N/A'}}</h4>
                            </a>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-credit-card f-50 text-c-blue"></i>
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
                            <a href="{{route('totalinq')}}">
                            <p class="m-b-5">Total Inquiry</p>
                            <h4 class="m-b-0">{{$inquiry ?? 'N/A'}}</h4>
                            </a>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-credit-card f-50 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="complaintstats" value="{{$compalintstats}}" />
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Complaint Chart</h5>
                </div>
                <div class="card-block">
                    <canvas id="myChartcomplaint" width="400" height="250"></canvas>
                </div>
                <div class="card-footer ">
                    <div class="row text-center b-t-default">
                        @foreach(json_decode($compalintstatsdata) as $key => $value)
                        <div class="col-3 b-r-default m-t-15">
                            <h5>{{$value ?? 'N/A'}}</h5>
                            <p class="text-muted m-b-0">{{$key}}</p>
                        </div>
                        @endforeach
                      
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="inquirystats" value="{{$inquirystats}}" />
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Inquiry Chart</h5>
                </div>
                <div class="card-block">
                    <canvas id="myChartinquiry" width="400" height="250"></canvas>
                </div>
                <div class="card-footer ">
                    <div class="row text-center b-t-default">
                        @foreach(json_decode($inquirystatsdata) as $key => $value)
                        <div class="col-6 b-r-default m-t-15">
                            <h5>{{$value ?? 'N/A'}}</h5>
                            <p class="text-muted m-b-0">{{$key}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

  




@endsection
