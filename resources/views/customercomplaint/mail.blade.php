<h3>Dear, {{ $name }}</h3>
<p>Your complaint, complaint no <strong>{{$uuid}}</strong> and title <strong>{{$title}}</strong> has been registered successfully.</p>
@php
$url = URL::to('/');

                        @endphp
<p>You can track your complaint using your mobile no at 
 <a href="{{$url}}" target="_blank">Follow the Grievance</a> 
 </p>

 <p>Thanks</p>
 <p>Bikaji Foods International Limited</p>