<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\UploadImage;

class CampaignController extends Controller
{
    public function uploadimage(){

        // array which contains the data to get the access token
        $fields = array(

            "client_id" => env('CLIENT_APP_ID'),
            "client_secret" => env('CLIENT_APP_SECRET') ,
            "grant_type" => "password" ,
            "email" => env('USER_EMAIL') ,
            "password" => env('USER_PASSWORD')

        );

        // A Curl request to get the access token
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,'https://www.teezily.com/oauth/token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($fields)))
        );
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result=curl_exec ($ch);


        curl_close ($ch);

        $token = json_decode($result,true);

        $imagepath = "slate.jpg";
        dispatch(new UploadImage($imagepath,$token['access_token'])); // Call the Job
    }
}
