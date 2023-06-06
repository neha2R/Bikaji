<!DOCTYPE html>
<html lang="en">

<head>
    <title>Welcome to Bikaji Care and Inquiry Portal </title>
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
    <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="https://customercare.bikajionline.com/files\bower_components\bootstrap\css\bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="https://customercare.bikajionline.com/files\assets\icon\themify-icons\themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="https://customercare.bikajionline.com/files\assets\icon\icofont\css\icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="https://customercare.bikajionline.com/files\assets\css\style.css">

    <style>
        .btn {

            background-color: DodgerBlue;
            border: none;

            padding: 12px 16px;

            cursor: pointer;
            text-transform: uppercase;
            width: 100%;
            letter-spacing: 2px;

            -moz-border-radius: 30px;
            border-radius: 0px;
            background: rgb(210, 20, 20);
            background: -moz-linear-gradient(90deg, rgb(210, 20, 20) 30%, rgb(250, 20, 20) 70%);

            background: -o-linear-gradient(90deg, rgb(210, 20, 20) 30%, rgb(250, 20, 20) 70%);
            background: -ms-linear-gradient(90deg, rgb(210, 20, 20) 30%, rgb(250, 20, 20) 70%);


        }


        .btn:hover {
            background-color: #03c6c8;
        }


        .dropdown-menu {
            width: 100%;
        }

        .dropdown-menu>li>a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: 400;
            line-height: 28px;
            color: #000;
            white-space: nowrap;
            text-align: center;
            font-size: 17px;
            font-weight: 600;
        }


        .btn>a {
            color: white;
            font-size: 16px;
            text-decoration: none;
        }
    </style>

</head>

<body class="fix-menu">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                    <form class="md-float-material form-material" method="POST" action="https://customercare.bikajionline.com/auth/login">
                        <input type="hidden" name="_token" value="FFmaknV7O6gboiX8HiWGDh5MgmhxsCNi5Xh5G1Ie">
                        <div class="text-center">
                            <img src="{{URL::asset('New-Logo.png')}}" alt="logo.png" height="100px" width="150px">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 style="    line-height: 40px;
    font-weight: 600;
    margin-top: 20px;" class="text-center">Welcome to Bikaji Care and Inquiry Portal</h3>
                                    </div>
                                </div>



                                <div class="row m-t-30">


                                    <div class="dropdown col-md-12" style="margin-bottom:10px;">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="menu3" data-toggle="dropdown" aria-expanded="false">Select your option ...
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu test" role="menu" aria-labelledby="menu3">

                                            <li role="presentation"><a role="menuitem" href="/customercomplaintform">I want to register a complaint</a></li>

                                            <li role="presentation"><a role="menuitem" href="/customerinquiryform">I want to inquire about business opportunities</a></li>
                                            <li role="presentation"><a role="menuitem" href="/trackcomplaint">I want to track progress on my complaint</a></li>

                                            <!-- <li role="presentation"><a role="menuitem" href="https://customercare.bikajionline.com/trackcomplaint">I want to track progress on my complaint</a></li> -->
                                        </ul>
                                    </div>



                                </div>
                                <hr>

                            </div>
                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
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
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\jquery\js\jquery.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\popper.js\js\popper.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\bootstrap\js\bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\modernizr\js\modernizr.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\modernizr\js\css-scrollbars.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\i18next\js\i18next.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\bower_components\jquery-i18next\js\jquery-i18next.min.js"></script>
    <script type="text/javascript" src="https://customercare.bikajionline.com/files\assets\js\common-pages.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
</body>

</html>