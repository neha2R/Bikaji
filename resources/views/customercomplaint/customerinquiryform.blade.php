<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Bikaji Care and Inquiry Portal</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/3.1/pusher.min.js"></script>
    <script>
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

        // Bind a function to a Event (the full Laravel class)
        channel.bind('complaintcreate', function(data) {
            $('.complaintnoti').append('<li><div class="media"><div class="media-body"><h5 class="notification-user">Complaint</h5><p class="notification-msg">' + data.message + '</p> <span class="notification-time">a few seconds ago</span> </div></div></li>');
        });
    </script>
        {!! NoCaptcha::renderJs() !!}

    <!------ Include the above in your HEAD tag ---------->
</head>
<body>
    <style>
 .section-title {
            color: #fff;
            margin-top: 25px;
        }
        .imglogo {
            width: 120px;
            height: 74px;
        }
        .btn-common {
    padding: 10px 50px !important;
    background: #ee272c !important;
    border-radius: 30px !important;
    color: #fff;
        }
    </style>    
<div style="background: rgb(236, 32, 40);">
        <div class="container">
            <div class="row">
                <div class="col-md-4"><a class="navbar-brand" href="https://www.bikaji.com"><img src="{{URL::asset('logo1.png')}}" class="imglogo"></a></div>
                <div class="col-md-8">
                    <h3 class="section-title">Register your inquiry here</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                  <!---  <div class="card-header bg-primary">
                        <h3 class="text-white">Feedback Form

</h3>
                    </div> -->
                    <div class="card-body">
  
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                     
                        <form class="shake" action="" method="POST" id="contactForm" name="contact-form" enctype="multipart/form-data">
                        @csrf
                              
                            <div class="row">
                            <div class="col-md-12 wow animated fadeInLeft" data-wow-delay=".2s" style="text-align: center">

<p style="margin-bottom: 40px;">Send us a note and we’ll get back to you as quickly as possible.</p>
</div>
@if (session()->has('msg'))
            <div class="alert alert-success" id="msg">
                {{session()->get('msg')}}
            </div>
            @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input class="form-control" id="name" type="text" placeholder="name" name="name" data-error="Please enter your name" minlength="3" maxlength="50" pattern="[a-zA-Z ]*$" value="{{ old('name')}}" oninvalid="setCustomValidity('Please enter on alphabets only. ')">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input class="form-control" id="email" type="email" name="email" placeholder="Email" value="{{ old('email')}}" data-error="Please enter your Email">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Mobile Number:</strong>
                                        <input class="form-control" id="phone" placeholder="Mobile Number" type="text" name="mobile" value="{{ old('mobile')}}" data-error="Please enter your Mobile Number">
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Pin No:</strong>
                                        <input class="form-control" id="pincode" placeholder="Pincode" type="text" name="pincode" value="{{ old('pincode')}}" minlength="6" maxlength="6">
                                        @if ($errors->has('pincode'))
                                            <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                        @endif
                                    </div>
                            </div>
    </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Details:</strong>
                                        <textarea class="form-control" rows="3" id="details" name="details" maxlength="250">
                            {{ old('details')}}
                            </textarea>                                        @if ($errors->has('details'))
                                            <span class="text-danger">{{ $errors->first('details') }}</span>
                                        @endif
                                    </div>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>State:</strong>
                                        <input class="form-control" id="state" placeholder="State" type="text" name="state" value="{{ old('state')}}">
                                        @if ($errors->has('state'))
                                            <span class="text-danger">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>City:</strong>
                                        <input class="form-control" maxlength="50" placeholder="City" id="city" type="text" value="{{ old('city')}}" name="city">
                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                            </div>
                        
                            <div class="form-group label-floating">
                            <label class="control-label" style="margin-left:20px;"><strong>Captcha</strong></label>
                        </div>

                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} label-floating">

                            <div class="col-md-6 mt-5">
                                {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Form Submit -->
                        <div class="form-submit mt-5" >
                            <button class="btn btn-common" style="margin-top:100px;" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Submit</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#phone").change(function(e) {
                ////alert("call");
                var length = $(this).val().length;
                if (length == 10) {

                    return true;
                } else {
                    alert("Please Enter only 10 digit mobile no")
                    $("#phone").focus();
                    return false;
                }
            });

            $('form').on('submit', function() {
                var mobileNum = $('#phone').val();
                var validateMobNum = /^\d*(?:\.\d{1,2})?$/;
                if (validateMobNum.test(mobileNum) && mobileNum.length == 10) {} else {
                    alert("Please Enter only 10 digit mobile no")
                    $("#phone").focus();
                    return false;
                }


            });

        });
    </script>
</body>

</html>
