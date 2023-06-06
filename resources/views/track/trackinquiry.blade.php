<!DOCTYPE html>
<html lang="en">

<head>
    <title>Track Inquiry</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row" style="margin-top: 10%">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Track Your Inquiry</h2>
                @if (session()->has('msg'))
                <div class="alert alert-success" id="msg">
                    {{session()->get('msg')}}
                </div>
                @endif
                @if (session()->has('message'))
                <div class="alert alert-danger" id="message">
                    {{session()->get('message')}}
                </div>
                @endif
                <form class="form-horizontal" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="refno">Reference Number:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="refno" placeholder="Enter reference here"
                            name="refno" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-10 col-sm-2">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</body>

</html>