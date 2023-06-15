<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Bikaji Care and Inquiry Portal</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/recaptcha/releases/Xh5Zjh8Od10-SgxpI_tcSnHR/recaptcha__en.js" nonce="">
      
    </script>
        {!! NoCaptcha::renderJs() !!}

    <link rel="stylesheet" type="text/css" href="https://www.gstatic.com/recaptcha/releases/Xh5Zjh8Od10-SgxpI_tcSnHR/styles__ltr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
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
                    <h3 class="section-title">Feedback Form</h3>
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
                     
                        <form method="POST" action="{{ route('complaint') }}" id="contactUSForm">
                            {{ csrf_field() }}
                              
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Message:</strong>
                                        <textarea name="complaint" rows="3" class="form-control">{{ old('complaint') }}</textarea>
                                        @if ($errors->has('complaint'))
                                            <span class="text-danger">{{ $errors->first('complaint') }}</span>
                                        @endif
                                    </div>  
                                </div>
                            </div>
                            <div class="form-group label-floating">
                            <label class="control-label">Captcha</label>
                        </div>
                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">

                            <div class="col-md-6">
                                {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                            <div class="form-group text-center">
                                <button class="btn btn-common btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
