<!DOCTYPE html>
<html lang="en">

<head>
    <title>Grivience System </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="{{URL::asset('files\assets\images\favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\bower_components\bootstrap\css\bootstrap.min.css')}}">
    <!-- radial chart.css -->
    <link rel="stylesheet" href="{{URL::asset('files\assets\pages\chart\radial\css\radial.css')}}" type="text/css" media="all">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\icon\feather\css\feather.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\css\style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\css\jquery.mCustomScrollbar.css')}}">
    <link href="{{URL::asset('files\assets\pages\jquery.filer\css\jquery.filer.css')}}" type="text/css" rel="stylesheet">
    <link href="{{URL::asset('files\assets\pages\jquery.filer\css\themes\jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{URl::asset('files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URl::asset('files\assets\pages\data-table\css\buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URl::asset('files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\bower_components\jquery.steps\css\jquery.steps.css')}}">
    <script type="text/javascript" src="{{URL::asset('files\bower_components\jquery\js\jquery.min.js')}}"></script>
</head>
<!-- Menu sidebar static layout -->

<body>
    <!-- Pre-loader start -->
    @component('components.common.loader')
    @endcomponent
    <!-- Pre-loader end -->
    <input type="hidden" id="userid" value="{{auth()->user()->id}}">
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="https://www.bikaji.com">
                            <img class="img-fluid" src="{{\Storage::disk('public')->url($logo)}}" alt="Logo">
                            {{-- <img class="img-fluid" src="https://www.bikaji.com/pub/media/logo1.png" alt="Theme-Logo" style="max-width: 67%;"> --}}
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            {{-- <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                    
                                </div>
                            </li> --}}
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                            <li><span>{{auth()->user()->email}}</span></li>
                        </ul>
                        <ul class="nav-right">
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown" id="notificationdiv">
                                    <div class="dropdown-toggle" data-toggle="dropdown" id="dropdowntoggle">
                                        <i class="feather icon-bell"></i>
                                        <span class="badge bg-c-pink"
                                            id="badge">{{countofnotification(auth()->user()->id)}}</span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu complaintnoti"
                                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="notificationbox" style="height:300px; overflow-y:scroll;">
                                        <li id="fixedli">
                                            <h6>Notifications</h6>
                                            {{-- <label class="label label-danger">New</label> --}}
                                            <button class="btn btn-primary clearnotification" data-id="{{auth()->user()->id}}" style="float: right; padding: 3px 12px;">Clear all</button>
                                        </li>
                                        <div class="allnotibox">
                                            @foreach (getnotifications(auth()->user()->id) as $item)
                                            <li>
                                                <div class="media">
                                                    <div class="media-body">
                                                        {{-- <h5 class="notification-user">Complaint</h5> --}}
                                                        <p class="notification-msg"> {!! $item->message !!} </p> <span class="notification-time">
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                            </li>
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{\Storage::disk('public')->url(auth()->user()->profileimage ??'N/A')}}" class="img-radius" alt="User-Profile-Image">
                                        <span></span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{route('ceoprofile')}}">
                                                <i class="feather icon-user"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('ceochangepassword')}}">
                                                <i class="feather icon-lock"></i> Change Password
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"  >
                                                <i class="feather icon-log-out"></i> Logout
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="">
                                    <a href="{{route('ceo')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <li class="">
                                    <!--<a href="{{route('ceocomplaint', ['type' => 'crossedtl'])}}"> ---->
                                    <a href="{{route('ceocomplaint')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Complaints</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('ceoinquiry')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Inquiries</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Track</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{route('ceotrackcomplaint')}}">
                                                <span class="pcoded-mtext">Complaint</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{route('ceotrackinquiry')}}">
                                                <span class="pcoded-mtext">Inquiry</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                       @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="../files/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="../files/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="../files/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="../files/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="../files/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    
    <script type="text/javascript" src="{{URL::asset('files\bower_components\jquery-ui\js\jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\popper.js\js\popper.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\bootstrap\js\bootstrap.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{URL::asset('files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{URL::asset('files\bower_components\modernizr\js\modernizr.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\modernizr\js\css-scrollbars.js')}}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{URL::asset('files\bower_components\chart.js\js\Chart.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{URL::asset('files\assets\js\ceopanel.js')}}"></script>
    <!-- Google map js -->
    {{-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="..\files\assets\pages\google-maps\gmaps.js"></script> --}}
    <!-- gauge js -->
    <script src="..\files\assets\pages\widget\gauge\gauge.min.js"></script>
    <script src="..\files\assets\pages\widget\amchart\amcharts.js"></script>
    <script src="..\files\assets\pages\widget\amchart\serial.js"></script>
    <script src="..\files\assets\pages\widget\amchart\gauge.js"></script>
    <script src="..\files\assets\pages\widget\amchart\pie.js"></script>
    <script src="..\files\assets\pages\widget\amchart\light.js"></script>
    {{-- <script src="{{URL::asset('files\assets\pages\jquery.filer\js\jquery.filer.min.js')}}"></script> --}}
    <script src="{{URL::asset('files\assets\pages\jquery.filer\js\jquery.filer.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\filer\custom-filer.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('files\assets\pages\filer\jquery.fileuploads.init.js')}}" type="text/javascript"></script>
    


    <script src="{{URL::asset('files\bower_components\datatables.net\js\jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\data-table\js\jszip.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\data-table\js\pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\data-table\js\vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\datatables.net-buttons\js\buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\datatables.net-buttons\js\buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\bootstrap-maxlength\js\bootstrap-maxlength.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('files\assets\pages\form-validation\validate.js')}}"></script>

    <script src=" {{URL::asset('files\bower_components\jquery.cookie\js\jquery.cookie.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\jquery.steps\js\jquery.steps.js')}}"></script>
    <script src="{{URL::asset('files\bower_components\jquery-validation\js\jquery.validate.js')}}"></script>

   

    <!-- Custom js -->
    <script src="{{URL::asset('files\assets\pages\forms-wizard-validation\form-wizard.js')}}"></script>
    <script src="{{URL::asset('files\assets\js\pcoded.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\js\vartical-layout.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\js\jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\assets\pages\dashboard\crm-dashboard.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\assets\js\script.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\data-table\js\data-table-custom.js')}}"></script>
  
    
    <script src="https://js.pusher.com/3.1/pusher.min.js"></script>
    <script>
        function appendnotification(data){
            var badgenum = $('#badge').html();
            var badge = parseInt(badgenum) + parseInt(1);
            $('#badge').html(badge);
            $('#fixedli').after('<li><div class="media"><div class="media-body"><p class="notification-msg">'+data.message+'</p> <span class="notification-time">a few seconds ago</span> </div></div></li>');
            $('#notificationbox').addClass('show');
            $('#notificationdiv').addClass('show');
            $('#dropdowntoggle').attr('aria-expanded', true);
        }
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // Initiate the Pusher JS library
        Pusher.logToConsole = true;
        var pusher = new Pusher('d2035391f217c913a305', {
            cluster: 'ap2',
            forceTLS: true
        });

        // Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('complaint-created');
        var channel2 = pusher.subscribe('complaint-resolved');
        var channel3 = pusher.subscribe('inquiry-created');
        var channel4 = pusher.subscribe('inquiry-resolved');

        // Bind a function to a Event (the full Laravel class)
        channel.bind('complaintcreate', function(data) {
            appendnotification(data);
        });

        channel2.bind('complaintresolved', function(data) {
            appendnotification(data);
        });

        channel3.bind('inquirycreate', function(data) {
            appendnotification(data);
        });

        channel4.bind('inquiryresolve', function(data) {
            appendnotification(data);
        });
    </script>

</body>

</html>
