<?php

$chatApiToken = ""; // Get it from https://www.phphive.info/255/get-whatsapp-password/

$number = "919999999999"; // Number
$message = "Hello :)"; // Message

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://chat-api.phphive.info/message/send/text',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array("jid" => $number . "@s.whatsapp.net", "message" => $message)),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $chatApiToken,
        'Content-Type: application/json',
    ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;



 function whatsup(){
    $message = 'Hello,

A complaint has been internally transferred to you, as it was related to your department.
You can check the complaint at this link http://care.bikaji.com/auth/login by logging in using your credentials.

Please resolve it within specified timeline to avoid escalation.';


$msg = rawurlencode($message);

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://media.smsgupshup.com/GatewayAPI/rest',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => "method=SendMessage&userid=2000198849&password=*Us9jRXz&msg=$msg&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to=8955465824&isTemplate=true&footer=Bikaji%20Foods%20International%20Limited&header=Internal%20Complaint%20Transfer%3A%20Bikaji%20Foods",
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
exit;
}

function whatsup2(){
    $message ='Dear Veer

Your complaint No. 123456 has been registered successfully in our system.
You can track your complaint using your mobile number at http://care.bikaji.com/trackcomplaint';

$msg = rawurlencode($message);
$header=rawurlencode('Complaint Registered: Bikaji Foods');
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://media.smsgupshup.com/GatewayAPI/rest',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => "method=SendMessage&userid=2000198849&password=*Us9jRXz&msg=$msg&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to=8955465824&isTemplate=true&footer=Bikaji%20Foods%20International%20Limited&header=$header",
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
exit;

}
