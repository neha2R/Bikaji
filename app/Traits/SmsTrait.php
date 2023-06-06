<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait SmsTrait
{
    public function sendsms($mobiles, $message)
    {

        if (is_array($mobiles)) {
            foreach ($mobiles as $key => $mobile) {
                $response = Http::get('http://alerts.prioritysms.com/api/web2sms.php', [
                    'workingkey' => 'Ad18f0224ee63efc00b7d3817d46f7fdc',
                    'to' => $mobile,
                    'sender' => 'BIKAJI',
                    'message' => $message,
                ]);
            }
        } else {
            $response = Http::get('http://alerts.prioritysms.com/api/web2sms.php', [
                'workingkey' => 'Ad18f0224ee63efc00b7d3817d46f7fdc',
                'to' => $mobiles,
                'sender' => 'BIKAJI',
                'message' => $message,
            ]);
        }
        return 200;
    }

    public static function sendmessage($msgid = null, $mobilenumber)
    {
        switch ($msgid) {
            case 1:
                $message = 'We are missing you at Vjourno. You can share a story, share a lead & create video for a request. Please contact admin at 9024829041  or call https://vjourno.net/ , in case you are feeling any issue. See you soon.';
                break;
            case 2:
                $message = 'Your account balance is critically low. Click link https://vjourno.net/ to recharge your account.';
                break;
            case 3:
                $message = 'Your monthly account statement is ready. You can download it by clicking link https://vjourno.net/.';
                break;
            case 4:
                $message = 'We have received a new video in marketplace, which might interest you. Click link https://vjourno.net/ to check the video.';
                break;
            case 5:
                $message = 'Welcome to VTPL. Please add our number in your contact list to keep getting updates, new video intimation, payment summary, minimum balance info etc.';
                break;
            case 6:
                $message = 'You are one of our most prestigious Vjourno app user. Share your thoughts about the app. If your views are shortlisted by our team, we will publish them on our portal along with your photograph.';
                break;
            case 7:
                $message = 'Click link https://vjourno.net/vjonweb  to check your monthly invoice. Share it with your friends & spread happiness.';
                break;
            case 8:
                $message = 'You have received a payment. Click here to see your earnings.';
                break;
            case 9:
                $message = 'You need to upload your documents again, as one or more of your document(s) is not in valid format. Click link to validate again https://vjourno.net/.';
                break;
            case 10:
                $message = 'Spare some time to verify yourself in our system. Your KYC is necessary to get payment in your bank account. Click link to upload your KYC documents https://vjourno.net/.';
                break;
            case 11:
                $message = 'Welcome to Vjourno. Please add our number in your contact list to keep getting updates, payment information etc.';
                break;

            default:
                $message = '';
                break;

        }
        $response = Http::get('https://media.smsgupshup.com/GatewayAPI/rest', [
            'userid' => '2000195584',
            'password' => '#x6XnQd2',
            'method' => 'SendMessage',
            'auth_scheme' => 'plain',
            'v' => 1.1,
            'send_to' => '91' . $mobilenumber,
            'msg' => $message,
            'msg_type' => 'HSM',
            'isHSM' => true,
            'isTemplate' => false,
            'data_encoding' => 'Text',
            'format' => 'json',
        ]);

        dd($response);

    }


    public static function sendWhatsappMessage($mobilenumber,$message,$header,$footer)
    {        
        //dd($mobilenumber);
        //$mobilenumber = '8955465824';
//        // $msgid = 1;
// $message ="Dear Sir/Ma'am,

// A new enquiry No. 112233 has been registered in the system.

// Please check the Bikaji Grievance Management Portal for faster resolution by clicking on this link: http://care.bikaji.com/auth/login";

        $en_msg = rawurlencode($message);
        $en_header=rawurlencode($header);
        $en_footer = rawurlencode($footer);
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
            CURLOPT_POSTFIELDS => "method=SendMessage&userid=2000198849&password=*Us9jRXz&msg=$en_msg&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to=$mobilenumber&isTemplate=true&footer=$en_footer&header=$en_header",
            CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

    $response = curl_exec($curl);
       // dd($response);
    curl_close($curl);
    }

    public static function whatsappMessage($message,$mobileNumber,$header,$footer)
    {
        $isTemplate='true';
        $en_footer=rawurlencode($footer);
        $en_header=rawurlencode($header);
        $en_message=rawurlencode($message);
      $response = Http::get('https://media.smsgupshup.com/GatewayAPI/rest', [
            'userid' => '2000198849',
            'password' => '*Us9jRXz',
            'phone_number' => '91'.$mobileNumber,
            'method' => 'OPT_IN',
            'auth_scheme' => 'plain',
            'v' => 1.1,
            'channel' => 'whatsapp',
            'format' => 'json',
        ]);
        $data = json_decode($response->body());
        $status = $data->response->status;
        //dd($status);
        
        if ($status == 'success')
        {


            
            if($en_header == null && $en_footer == null)
            { 
              
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
                CURLOPT_POSTFIELDS => 'method=SendMessage&userid=2000198849&password=*Us9jRXz&msg='.$en_message.'&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to='.$mobileNumber.'&isTemplate='.$isTemplate,
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),));
                $response = curl_exec($curl);
    
                curl_close($curl);
                //dd($response,'hekko');
            }
            else
            {
                
                $curl = curl_init();
             //   dd($isTemplate);
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://media.smsgupshup.com/GatewayAPI/rest',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'method=SendMessage&userid=2000198849&password=*Us9jRXz&msg='.$en_message.'&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to='.$mobileNumber.'&isTemplate='.$isTemplate.'&footer='.$en_footer.'&header='.$en_header,
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),));
                $response = curl_exec($curl);
    
                curl_close($curl);
                $data = json_decode($response);
                $status = $data->response->status;
                //dd($response);

            }

        }
 
    }

}
