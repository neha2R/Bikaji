<?php

use Illuminate\Support\Facades\Http;


class WhatsappMessagesService
{
    public $message, $mobile_number;

     
    public static function whatsappMessage($message,$mobileNumber,$header=null,$footer=null)
    {$isTemplate='true';
        try {
            $response = Http::get('https://media.smsgupshup.com/GatewayAPI/rest', [
                'userid' => '2000195584',
                'password' => '#x6XnQd2',
                'phone_number' => '91'.$mobileNumber,
                'method' => 'OPT_IN',
                'auth_scheme' => 'plain',
                'v' => 1.1,
                'channel' => 'whatsapp',
                'format' => 'json',
            ]);
            $data = json_decode($response->body());
            $status = $data->response->status;
           // dd($message);
            
            if ($status == 'success') {
                
                
                $response = Http::get('https://media.smsgupshup.com/GatewayAPI/rest', [
                    'userid' => '2000195584',
                    'password' => '#x6XnQd2',
                    'method' => 'SendMessage',
                    'auth_scheme' => 'plain',
                    'v' => 1.1,
                    'send_to' => '91'.$mobileNumber,
                    'msg' => rawurldecode($message),
                    'msg_type' => 'HSM',
                    'isHSM' => true,
                    'isTemplate' => $isTemplate,
                    'data_encoding' => 'Text',
                    'format' => 'json',
                 
                ]);
               // dd($response->body());
                return $response;
            
            }else{
                $response=$data->response->id;
                switch ($status) {
                    case 100:
                        return 0;
                        break;
                    case 101:
                        return 0;
                        break;
                    case 102:
                        return 0;
                        break;
                    case 103:
                        return 0;
                        break;
                    case 105:
                        return 0;
                        break;
                    case 106:
                        return 0;
                        break;
                    case 175:
                        return 0;
                        break;
                    case 312:
                        return 1;
                        break;
                    default:
                        return 0;
                        break;
                }
            }
        } catch (\Throwable $th) {
           // dd($th);
        }
    }


}