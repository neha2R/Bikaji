<!DOCTYPE html>
<html lang="en">

<head>
    <title> Grievance Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{URL::asset('files/assets/css/trackingstatus.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row shop-tracking-status" style="margin-top: 10%">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2> Status of the Complaint</h2>
                <div class="row d-flex justify-content-center">
                    <div class="col-12">
                        <ul id="progressbar" class="text-center">
                            <li class="active step0"></li>
                            <li class="active step0"></li>
                            @if ($gettransitions)
                            @if ($gettransitions->is_resolved)
                            <li class="active step0"></li>
                            @else
                            <li class="step0"></li>
                            @endif
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-between top">
                    <div class="row d-flex icon-content">
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">Complaint Received</p>
                        </div>
                    </div>
                    <div class="row d-flex icon-content">
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">In Progress</p>
                        </div>
                    </div>
                    <div class="row d-flex icon-content">
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">Resolved</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if ($gettransitions)
                        @if ($gettransitions->is_resolved)
                        <ul>
                            <li>
                               <strong>Resolved By</strong> :  <strong>{{optional($gettransitions->touserrelation)->name}}</strong>
                            </li>
                            <li>
                               <strong>Department</strong> :  <strong>{{optional($gettransitions->department)->name}}</strong>
                            </li>
                        </ul>
                        @else
                        <ul>
                            <li>
                               <strong>Resolving By</strong> :  <strong>{{optional($gettransitions->touserrelation)->name}}</strong>
                            </li>
                            <li>
                                <strong>Department</strong> :  <strong>{{optional($gettransitions->department)->name}}</strong>
                             </li>
                        </ul>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</body>

</html>
