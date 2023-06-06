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
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon icon -->
    <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\bower_components\bootstrap\css\bootstrap.min.css')}}">
    <!-- radial chart.css -->
    <link rel="stylesheet" href="{{URL::asset('files\assets\pages\chart\radial\css\radial.css')}}" type="text/css" media="all">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\icon\feather\css\feather.css')}}">
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\icofont\css\icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\css\style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\css\jquery.mCustomScrollbar.css')}}">
    <link href="{{URL::asset('files\assets\pages\jquery.filer\css\jquery.filer.css')}}" type="text/css" rel="stylesheet">
    <link href="{{URL::asset('files\assets\pages\jquery.filer\css\themes\jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\assets\pages\data-table\css\buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\chartist\css\chartist.css">
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\animate.css\css\animate.css">
    <script type="text/javascript" src="{{URL::asset('files\bower_components\jquery\js\jquery.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\js\sweetalert.js')}}"></script>
    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }
        
        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        input:checked + .slider {
          background-color: #2196F3;
        }
        
        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }
        
        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }
        
        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }
        
        .slider.round:before {
          border-radius: 50%;
        }
        </style>
</head>
<!-- Menu sidebar static layout -->

<body>
    <!-- Pre-loader start -->
    @component('components.common.loader')
    @endcomponent
    <!-- Pre-loader end -->
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
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{\Storage::disk('public')->url(auth()->user()->profileimage ??'N/A')}}" class="img-radius" alt="User-Profile-Image">
                                        <span></span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{route('adminprofile')}}">
                                                <i class="feather icon-user"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('adminchangepassword')}}">
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
                                {{-- <li class="pcoded-hasmenu active pcoded-trigger">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="index-1.htm">
                                                <span class="pcoded-mtext">Default</span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="dashboard-crm.htm">
                                                <span class="pcoded-mtext">CRM</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="dashboard-analytics.htm">
                                                <span class="pcoded-mtext">Analytics</span>
                                                <span class="pcoded-badge label label-info ">NEW</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                                <li class="">
                                    <a href="{{route('admindashboard')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('adminnotificationmethods')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Notification Methods</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('adminlevels')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Levels</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('adminemployee')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Employee</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('configurationactions')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Configurations</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('deparment')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Department</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('inquirytype')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Inquiry Type</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('totalcomplaints')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Complaints</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{route('totalinq')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Inquiry</span>
                                    </a>
                                </li>
                                {{-- <li class="">
                                    <a href="{{route('complainttype')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Complaint Type</span>
                                    </a>
                                </li> --}}
                                <li class="">
                                    <a href="{{route('uploadlogo')}}">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Upload Logo</span>
                                    </a>
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

    <script type="text/javascript" src=" {{URL::asset('files\bower_components\jquery-ui\js\jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\popper.js\js\popper.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\bootstrap\js\bootstrap.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{URL::asset('files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{URL::asset('files\bower_components\modernizr\js\modernizr.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\bower_components\modernizr\js\css-scrollbars.js')}}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{URL::asset('files\bower_components\chart.js\js\Chart.js')}}"></script>
    <!-- Google map js -->
    {{-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="..\files\assets\pages\google-maps\gmaps.js"></script> --}}
    <!-- gauge js -->
    {{-- <script src="{{URL::asset('files\assets\pages\jquery.filer\js\jquery.filer.min.js')}}"></script> --}}
    <script src="{{URL::asset('files\assets\pages\jquery.filer\js\jquery.filer.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\filer\custom-filer.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('files\assets\pages\filer\jquery.fileuploads.init.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('files\bower_components\switchery\js\switchery.min.js')}}"></script>
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
    <script src="{{URL::asset('files\bower_components\bootstrap-maxlength\js\bootstrap-maxlength.js')}}"></script>
    <script type="text/javascript" src="..\files\bower_components\chart.js\js\Chart.js"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="..\files\assets\pages\chart\chartjs\chartjs-custom.js"></script>
    <script src="{{URL::asset('files\assets\js\pcoded.min.js')}}"></script>
    <script src="{{URl::asset('files\assets\js\vartical-layout.min.js')}}"></script>
    <script src="{{URL::asset('files\assets\js\jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\assets\pages\dashboard\crm-dashboard.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('files\assets\js\script.js')}}"></script>
    <script src="{{URL::asset('files\assets\pages\data-table\js\data-table-custom.js')}}"></script>
    <script src="{{URL::asset('admin/custom.js')}}"></script>
    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            html: true,
            content: function() {
                return $('#primary-popover-content').html();
            }
        });
    });

    </script>
     <script src="{{URL::asset('files\assets\js\juniorlevel.js')}}"></script>

</body>

</html>