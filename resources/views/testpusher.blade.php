<!DOCTYPE html>
<html>
  <head>
    <title> Pusher</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="content">
        <h1>Test Pusher</h1>
        <ul id="messages" class="list-group">
        </ul>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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
    console.log(data);
});
    </script>
  </body>
</html>