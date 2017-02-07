<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $imagepath; // declaring a public variable to get the image path
    private $headers = array(); // array for headers
    public $token; // Access Token
    public function __construct($imagepath,$token)
    {
        $this->imagepath = $imagepath;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->headers[]  = "Authorization: Bearer ".$this->token;
        $this->headers[] = "Content-Type:multipart/form-data";
        $target_url = 'https://www.teezily.com/api/v1/images';
        $cFile = '@' . public_path($this->imagepath);// Get the real path

        $files =  array("files" => $cFile);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_URL,$target_url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$files);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result=curl_exec ($ch);
        echo "result =>".$result;
       // echo "error".curl_error($ch);
        curl_close ($ch);
            }
}
